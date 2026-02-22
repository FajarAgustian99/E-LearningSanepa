<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Classes;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class StudentDiscussionController extends Controller
{
    /**
     * Daftar diskusi
     */
    public function index()
    {
        $discussions = Discussion::with(['user', 'classes'])
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        return view('student.forum.index', compact('discussions'));
    }

    /**
     * Form buat diskusi baru
     */
    public function create()
    {
        $classes = Classes::all();
        return view('student.forum.create', compact('classes'));
    }

    /**
     * Simpan diskusi baru +  NOTIFIKASI
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'class_id' => 'required|exists:classes,id',
        ]);

        $authUser = Auth::user();

        // Dapatkan teacher_id jika ada guru di kelas
        $teacher = User::whereHas('teachingClasses', function ($q) use ($request) {
            $q->where('classes.id', $request->class_id);
        })->first();

        // Simpan diskusi
        $discussion = Discussion::create([
            'user_id'    => $authUser->id,
            'class_id'   => $request->class_id,
            'teacher_id' => $teacher?->id, // nullable jika tidak ada guru
            'title'      => $request->title,
            'content'    => $request->content,
        ]);

        /*
        |----------------------------------------------------------------------
        |  NOTIFIKASI KE GURU KELAS
        |----------------------------------------------------------------------
        */
        $teachers = User::whereHas('teachingClasses', function ($q) use ($request) {
            $q->where('classes.id', $request->class_id);
        })->get();

        foreach ($teachers as $teacher) {
            if ($teacher->id !== $authUser->id) {
                Notification::create([
                    'user_id' => $teacher->id,
                    'message' => '📢 Diskusi baru dari siswa: "' . $discussion->title . '"',
                    'is_read' => false,
                ]);
            }
        }

        /*
        |----------------------------------------------------------------------
        |  NOTIFIKASI KE SISWA LAIN DI KELAS
        |----------------------------------------------------------------------
        */
        $students = User::where('class_id', $request->class_id)
            ->where('id', '!=', $authUser->id)
            ->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'message' => '💬 Diskusi baru di kelas: "' . $discussion->title . '"',
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('student.forum.index')
            ->with('success', 'Diskusi berhasil dibuat dan notifikasi dikirim.');
    }

    /**
     * Detail diskusi + komentar
     */
    public function show(Discussion $discussion)
    {
        $discussion->load([
            'user',
            'classes',
            'comments' => function ($q) {
                $q->whereNull('parent_id')->with('children.user');
            }
        ]);

        return view('student.forum.show', compact('discussion'));
    }

    /**
     * Simpan reply komentar +  NOTIFIKASI
     */
    public function storeReply(Request $request, Discussion $discussion)
    {
        $request->validate([
            'content'   => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $authUser = Auth::user();

        // Simpan komentar
        $comment = $discussion->comments()->create([
            'user_id'   => $authUser->id,
            'content'   => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        /*
        |----------------------------------------------------------------------
        |  NOTIFIKASI KE PEMBUAT DISKUSI
        |----------------------------------------------------------------------
        */
        if ($discussion->user?->id && $discussion->user->id !== $authUser->id) {
            Notification::create([
                'user_id' => $discussion->user->id,
                'message' => '💬 Komentar baru pada diskusi: "' . $discussion->title . '"',
                'is_read' => false,
            ]);
        }

        /*
        |----------------------------------------------------------------------
        |  NOTIFIKASI KE GURU KELAS
        |----------------------------------------------------------------------
        */
        $teachers = User::whereHas('teachingClasses', function ($q) use ($discussion) {
            $q->where('classes.id', $discussion->class_id);
        })->get();

        foreach ($teachers as $teacher) {
            if ($teacher->id !== $authUser->id) {
                Notification::create([
                    'user_id' => $teacher->id,
                    'message' => '💬 Komentar baru di diskusi: "' . $discussion->title . '"',
                    'is_read' => false,
                ]);
            }
        }

        return redirect()
            ->route('student.forum.show', $discussion)
            ->with('success', 'Balasan berhasil dikirim dan notifikasi dikirim.');
    }
}
