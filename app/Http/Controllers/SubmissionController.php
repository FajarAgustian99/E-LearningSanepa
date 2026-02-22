<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'file' => 'required|file|max:10240'
        ]);
        $path = $request->file('file')->store('submissions', 'public');
        $data['file'] = $path;
        $data['user_id'] = auth()->id();
        $data['submitted_at'] = now();
        \App\Models\Submission::updateOrCreate(
            ['assignment_id' => $data['assignment_id'], 'user_id' => auth()->id()],
            $data
        );
        return back()->with('success', 'Submission berhasil diunggah');
    }
}
