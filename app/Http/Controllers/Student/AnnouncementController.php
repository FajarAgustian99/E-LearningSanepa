<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {

        $user = auth()->user();


        $announcements = Announcement::latest()->paginate(10);

        return view('student.announcement.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        return view('student.announcement.show', compact('announcement'));
    }
}
