<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Material;
use App\Models\Classes;
use App\Models\User;
use App\Models\Notification;

class MaterialController extends Controller
{
    /**
     * 📘 Daftar materi
     */
    public function index($class_id)
    {
        $class = Classes::with(['materials'])->findOrFail($class_id);
        return view('teacher.materials.index', compact('class'));
    }

    /**
     *  Form tambah materi
     */
    public function create($class_id)
    {
        $class = Classes::findOrFail($class_id);
        return view('teacher.materials.create', compact('class'));
    }

    /**
     *  Simpan materi baru +  NOTIFIKASI
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id'          => 'required|exists:classes,id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:2000',
            'file'              => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20480',
            'meeting_link'      => 'nullable|url',
            'link_upload'       => 'nullable|url',
            'allow_task_upload' => 'nullable|boolean',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
        }

        $material = Material::create([
            'class_id'          => $request->class_id,
            'title'             => $request->title,
            'description'       => $request->description,
            'file'              => $filePath,
            'meeting_link'      => $request->meeting_link,
            'link_upload'       => $request->link_upload,
            'allow_task_upload' => $request->has('allow_task_upload'),
        ]);

        /*
        |--------------------------------------------------------------------------
        |  NOTIFIKASI KE SISWA DI KELAS
        |--------------------------------------------------------------------------
        */
        $students = User::where('class_id', $request->class_id)->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'message' => '📘 Materi baru: "' . $material->title . '" telah diupload.',
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('teacher.materi.index', $request->class_id)
            ->with('success', 'Materi berhasil diupload dan notifikasi dikirim.');
    }

    /**
     * ✏️ Edit materi
     */
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $class = Classes::findOrFail($material->class_id);

        return view('teacher.materials.edit', compact('material', 'class'));
    }

    /**
     * 🔄 Update materi + 🔔 NOTIFIKASI
     */
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:2000',
            'file'              => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20480',
            'meeting_link'      => 'nullable|url',
            'link_upload'       => 'nullable|url',
            'allow_task_upload' => 'nullable|boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($material->file && Storage::disk('public')->exists($material->file)) {
                Storage::disk('public')->delete($material->file);
            }
            $filePath = $request->file('file')->store('materials', 'public');
        } else {
            $filePath = $material->file;
        }

        $material->update([
            'title'             => $request->title,
            'description'       => $request->description,
            'file'              => $filePath,
            'meeting_link'      => $request->meeting_link,
            'link_upload'       => $request->link_upload,
            'allow_task_upload' => $request->has('allow_task_upload'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | 🔔 NOTIFIKASI UPDATE KE SISWA
        |--------------------------------------------------------------------------
        */
        $students = User::where('class_id', $material->class_id)->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'message' => '✏️ Materi diperbarui: "' . $material->title . '"',
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('teacher.materi.index', $material->class_id)
            ->with('success', 'Materi berhasil diperbarui dan notifikasi dikirim.');
    }

    /**
     * 🗑 Hapus materi
     */
    public function destroy($id)
    {
        $material = Material::findOrFail($id);

        if ($material->file && Storage::disk('public')->exists($material->file)) {
            Storage::disk('public')->delete($material->file);
        }

        $material->delete();

        return redirect()->back()->with('success', 'Materi berhasil dihapus.');
    }
}
