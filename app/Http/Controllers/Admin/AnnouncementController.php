<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Notification;


class AnnouncementController extends Controller
{
    // Tampilkan daftar pengumuman
    public function index()
    {
        $announcements = Announcement::orderBy('date', 'desc')->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    // Form tambah pengumuman baru
    public function create()
    {
        return view('admin.announcements.create');
    }

    // Simpan pengumuman baru
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
        ]);

        // 1. Simpan pengumuman
        $announcement = Announcement::create($request->all());

        // 2. Ambil SISWA + GURU
        User::whereHas('role', function ($query) {
            $query->whereIn('name', ['Guru', 'Siswa']);
        })

            ->each(function ($user) use ($announcement) {
                Notification::create([
                    'user_id' => $user->id,
                    'message' => 'Pengumuman baru: ' . $announcement->title,
                    'is_read' => false,
                ]);
            });

        // 3. Redirect dengan pesan sukses

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat dan notifikasi dikirim ke siswa & guru.');
    }

    // Form edit pengumuman
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Pastikan date jadi objek Carbon
        $announcement->date = \Carbon\Carbon::parse($announcement->date);

        return view('admin.announcements.edit', compact('announcement'));
    }

    // Update pengumuman
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $announcement->update($request->all());

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    // Hapus pengumuman
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
