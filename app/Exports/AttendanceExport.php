<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceExport implements FromView
{
    protected $classId;
    protected $courseId;
    protected $month;

    public function __construct($classId, $courseId, $month)
    {
        $this->classId = $classId;
        $this->courseId = $courseId;
        $this->month = $month;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $start = $this->month . '-01';
        $end = date('Y-m-t', strtotime($start));

        $attendances = \App\Models\Attendance::where('class_id', $this->classId)
            ->whereBetween('date', [$start, $end])
            ->when($this->courseId, function ($q) {
                $q->where('course_id', $this->courseId);
            })
            ->get();


        // Ambil siswa dari attendance supaya pasti ada
        $students = \App\Models\User::whereIn(
            'id',
            $attendances->pluck('student_id')->unique()
        )->get();

        $rekap = [];

        foreach ($students as $student) {

            $data = $attendances->where('student_id', $student->id);

            $hadir = $data->where('status', 'Hadir')->count();
            $izin  = $data->where('status', 'Izin')->count();
            $sakit = $data->where('status', 'Sakit')->count();
            $alpha = $data->where('status', 'Alpha')->count();

            $rekap[$student->id] = [
                'Hadir' => $hadir,
                'Izin'  => $izin,
                'Sakit' => $sakit,
                'Alpha' => $alpha,
                'Total' => $hadir + $izin + $sakit + $alpha,
            ];
        }

        $kelas = \App\Models\Classes::find($this->classId);

        return view('teacher.attendance.export', [
            'kelas' => $kelas,
            'students' => $students,
            'rekap' => $rekap,
            'month' => $this->month,
        ]);
    }
}
