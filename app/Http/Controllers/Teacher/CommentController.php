<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Discussion;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Simpan komentar + NOTIFIKASI
     */
    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // Simpan komentar
        $comment = Comment::create([
            'discussion_id' => $discussion->id,
            'user_id'       => Auth::id(),
            'parent_id'     => $request->parent_id,
            'content'       => $request->content,
        ]);

        // Update waktu diskusi
        $discussion->touch();

        $authUser = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | 🔔 NOTIFIKASI KE GURU PEMBUAT DISKUSI
        |--------------------------------------------------------------------------
        */
        if ($discussion->teacher_id !== $authUser->id) {
            Notification::create([
                'user_id' => $discussion->teacher_id,
                'message' => '💬 Komentar baru pada diskusi: "' . $discussion->title . '"',
                'is_read' => false,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 🔔 NOTIFIKASI KE SISWA LAIN DI KELAS 
        |--------------------------------------------------------------------------
        */
        $students = User::where('class_id', $discussion->class_id)
            ->whereHas('role', function ($q) {
                $q->where('name', 'Siswa');
            })
            ->where('id', '!=', $authUser->id) // jangan kirim ke diri sendiri
            ->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'message' => '💬 Komentar baru di diskusi: "' . $discussion->title . '"',
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Hapus komentar
     */
    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        // Guru atau pemilik komentar boleh hapus
        if ($comment->user_id !== $user->id && $user->role->name !== 'Guru') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
