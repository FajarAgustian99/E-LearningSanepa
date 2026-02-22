<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Classes;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    /**
     * Daftar diskusi guru
     */
    public function index()
    {
        $teacherId = Auth::id();

        $discussions = Discussion::where('teacher_id', $teacherId)
            ->with('classes')
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        return view('teacher.discussions.index', compact('discussions'));
    }

    /**
     * Form buat diskusi baru
     */
    public function create()
    {
        $teacherId = Auth::id();

        $classes = Classes::where('teacher_id', $teacherId)->get();

        return view('teacher.discussions.create', compact('classes'));
    }

    /**
     * Simpan diskusi baru + NOTIFIKASI KE SISWA
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'class_id' => 'required|exists:classes,id',
        ]);

        // 1️⃣ Simpan diskusi
        $discussion = Discussion::create([
            'class_id'   => $request->class_id,
            'teacher_id' => Auth::id(),
            'user_id'    => Auth::id(),
            'title'      => $request->title,
            'content'    => $request->content,
        ]);

        // 2️⃣ Ambil SISWA yang join kelas tersebut
        $students = User::whereHas('joinedClasses', function ($q) use ($request) {
            $q->where('classes.id', $request->class_id);
        })->get();



        // 🔔 Kirim notifikasi ke siswa di kelas tersebut
        $students = User::where('class_id', $request->class_id)
            ->whereHas('role', function ($q) {
                $q->where('name', 'Siswa');
            })
            ->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'message' => '💬 Diskusi baru dibuat: "' . $discussion->title . '"',
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('teacher.discussions.index')
            ->with('success', 'Diskusi berhasil dibuat dan notifikasi dikirim ke siswa.');
    }

    /**
     * Detail thread diskusi + komentar
     */
    public function showThread($classId, $threadId)
    {
        $class = Classes::findOrFail($classId);

        $discussion = Discussion::with([
            'user',
            'comments' => function ($q) {
                $q->whereNull('parent_id')->with('replies.user');
            },
            'classes'
        ])->findOrFail($threadId);

        return view('teacher.discussions.thread', compact('class', 'discussion'));
    }

    /**
     * Hapus diskusi
     */
    public function destroy(Discussion $discussion)
    {
        if ($discussion->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin.');
        }

        $discussion->delete();

        return redirect()
            ->route('teacher.discussions.index')
            ->with('success', 'Diskusi berhasil dihapus!');
    }
}
