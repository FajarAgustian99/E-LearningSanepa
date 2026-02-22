<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseApiController extends Controller
{
    public function index()
    {
        return Course::with('teacher')->paginate(10);
    }
    public function show(Course $course)
    {
        return $course->load('teacher', 'assignments');
    }
    public function store(Request $r)
    {
        $r->validate(['title' => 'required', 'teacher_id' => 'required|exists:users,id']);
        $c = Course::create($r->all());
        return response()->json($c, 201);
    }
    public function update(Request $r, Course $course)
    {
        $r->validate(['title' => 'required']);
        $course->update($r->all());
        return response()->json($course);
    }
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(null, 204);
    }
}
