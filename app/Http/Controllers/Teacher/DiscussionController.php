<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Classes;
use App\Models\User;
use App\Models\Notification;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
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

    public function create()
    {
        $classes = Classes::where('teacher_id', Auth::id())->get();

        return view('teacher.discussions.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Pastikan kelas milik guru
        $class = Classes::where('id', $request->class_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        $discussion = Discussion::create([
            'class_id'   => $class->id,
            'teacher_id' => Auth::id(),
            'user_id'    => Auth::id(),
            'title'      => $request->title,
            'content'    => $request->content,
        ]);

        // Ambil siswa di kelas tersebut
        $students = User::where('class_id', $class->id)
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
            ->with('success', 'Diskusi berhasil dibuat dan notifikasi dikirim.');
    }

    public function edit(Discussion $discussion)
    {
        if ($discussion->teacher_id !== Auth::id()) {
            abort(403);
        }

        $classes = Classes::where('teacher_id', Auth::id())->get();

        return view('teacher.discussions.edit', compact('discussion', 'classes'));
    }

    public function update(Request $request, Discussion $discussion)
    {
        if ($discussion->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'class_id' => 'required|exists:classes,id',
        ]);

        $discussion->update([
            'class_id' => $request->class_id,
            'title'    => $request->title,
            'content'  => $request->content,
        ]);

        return redirect()
            ->route('teacher.discussions.index')
            ->with('success', 'Diskusi berhasil diperbarui!');
    }

    public function showThread($classId, $threadId)
    {
        $class = Classes::where('id', $classId)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        $discussion = Discussion::with([
            'user',
            'comments' => function ($q) {
                $q->whereNull('parent_id')->with('replies.user');
            },
            'classes'
        ])->findOrFail($threadId);

        return view('teacher.discussions.thread', compact('class', 'discussion'));
    }

    public function destroy(Discussion $discussion)
    {
        if ($discussion->teacher_id !== Auth::id()) {
            abort(403);
        }

        $discussion->delete();

        return redirect()
            ->route('teacher.discussions.index')
            ->with('success', 'Diskusi berhasil dihapus!');
    }
}
