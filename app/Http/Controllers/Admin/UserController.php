<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ===============================
    // INDEX
    // ===============================
    public function index(Request $request)
    {
        $searchAdmin = $request->input('search_admin');
        $searchGuru  = $request->input('search_guru');
        $searchSiswa = $request->input('search_siswa');

        // Admin
        $admins = User::whereHas('role', fn($q) => $q->where('name', 'Admin'))
            ->when($searchAdmin, function ($query) use ($searchAdmin) {
                $query->where(function ($q) use ($searchAdmin) {
                    $q->where('name', 'like', "%{$searchAdmin}%")
                        ->orWhere('npsn', 'like', "%{$searchAdmin}%");
                });
            })
            ->orderBy('name')
            ->paginate(10, ['*'], 'admin_page');

        // Guru
        $gurus = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))
            ->when($searchGuru, function ($query) use ($searchGuru) {
                $query->where(function ($q) use ($searchGuru) {
                    $q->where('name', 'like', "%{$searchGuru}%")
                        ->orWhere('nip', 'like', "%{$searchGuru}%");
                });
            })
            ->orderBy('name')
            ->paginate(10, ['*'], 'guru_page');

        // Siswa
        $siswas = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))
            ->when($searchSiswa, function ($query) use ($searchSiswa) {
                $query->where(function ($q) use ($searchSiswa) {
                    $q->where('name', 'like', "%{$searchSiswa}%")
                        ->orWhere('nisn', 'like', "%{$searchSiswa}%");
                });
            })
            ->orderBy('name')
            ->paginate(10, ['*'], 'siswa_page');

        return view('admin.users.index', compact(
            'admins',
            'gurus',
            'siswas',
            'searchAdmin',
            'searchGuru',
            'searchSiswa'
        ));
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $roles = Role::all();
        $classes = Classes::orderBy('name')->get();
        return view('admin.users.create', compact('roles', 'classes'));
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'role_id'  => 'required',
            'password' => 'required|min:6',
            'class_id' => 'nullable|exists:classes,id',
            'nip'      => 'nullable|unique:users,nip',
            'nisn'     => 'nullable|unique:users,nisn',
            'npsn'     => 'nullable|unique:users,npsn',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'role_id'  => $request->role_id,
            'password' => Hash::make($request->password),
            'nip'      => $request->nip,
            'nisn'     => $request->nisn,
            'npsn'     => $request->npsn,
        ]);

        // ✅ JIKA SISWA & ADA KELAS → ISI PIVOT
        if ($request->class_id && $user->role->name === 'Siswa') {
            $user->classes()->syncWithoutDetaching([
                $request->class_id => ['role' => 'student']
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan & kelas otomatis terhubung');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit(User $user)
    {
        $roles = Role::all();
        $classes = Classes::all();
        return view('admin.users.edit', compact('user', 'roles', 'classes'));
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required',
            'role_id'  => 'required',
            'class_id' => 'nullable|exists:classes,id',
            'nip'      => 'nullable|unique:users,nip,' . $user->id,
            'nisn'     => 'nullable|unique:users,nisn,' . $user->id,
            'npsn'     => 'nullable|unique:users,npsn,' . $user->id,
        ]);

        $data = $request->only([
            'name',
            'role_id',
            'nip',
            'nisn',
            'npsn'
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // ✅ SYNC KELAS SISWA
        if ($user->role->name === 'Siswa') {
            if ($request->class_id) {
                $user->classes()->sync([
                    $request->class_id => ['role' => 'student']
                ]);
            } else {
                $user->classes()->detach();
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate & kelas disinkronkan');
    }


    // ===============================
    // DELETE
    // ===============================
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
}
