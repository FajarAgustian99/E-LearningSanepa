<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // ==========================
    // TAMPILKAN PROFIL
    // ==========================
    public function show(Request $request)
    {
        $user = $request->user();
        return view('student.profile.show', compact('user'));
    }

    // ==========================
    // UPDATE DATA PROFILE
    // ==========================
    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users,email,' . $user->id,
            'nisn'   => 'nullable|string|max:20',
            'class'  => 'nullable|string|max:50',
            'phone'  => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($validatedData);

        return redirect()->route('student.profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    // ==========================
    // UPDATE FOTO PROFILE
    // ==========================
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();

        // Hapus foto lama
        if ($user->photo && Storage::disk('public')->exists('profile/' . $user->photo)) {
            Storage::disk('public')->delete('profile/' . $user->photo);
        }

        // Upload foto baru
        $file = $request->file('photo');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('profile', $fileName, 'public');

        $user->photo = $fileName;
        $user->save();

        return redirect()->route('student.profile.show')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    // ==========================
    // UPDATE PASSWORD
    // ==========================
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6|confirmed',
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('student.profile.show')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
