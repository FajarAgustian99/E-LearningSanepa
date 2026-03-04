<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     *  Tampilkan halaman profil guru.
     */
    public function index()
    {
        $user = Auth::user();
        return view('teacher.profile.index', compact('user'));
    }

    /**
     *  Update data diri guru (tanpa foto).
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'nip'     => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:100',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user = Auth::user();

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'nip'     => $request->nip,
            'subject' => $request->subject,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     *  Update foto profil guru.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $user = Auth::user();

        // Hapus foto lama
        if ($user->photo && Storage::disk('public')->exists('profile/' . $user->photo)) {
            Storage::disk('public')->delete('profile/' . $user->photo);
        }

        // Upload foto baru
        $filename = time() . '.' . $request->photo->extension();
        $request->photo->storeAs('profile', $filename, 'public');

        // Update database
        $user->photo = $filename;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }


    /**
     *  Update password guru.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
