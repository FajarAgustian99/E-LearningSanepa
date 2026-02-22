<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AdminAttendanceExport implements FromCollection, WithHeadings
{
    protected $course_id, $date, $type, $class_id;

    public function __construct($course_id, $date, $type, $class_id = null)
    {
        $this->course_id = $course_id;
        $this->date = $date;
        $this->type = $type;
        $this->class_id = $class_id;
    }

    /**
     * Dipakai Excel
     */
    public function collection()
    {
        return new Collection($this->getRows());
    }

    /**
     * Dipakai PDF juga
     */
    public function getRows(): array
    {
        if ($this->type === 'teacher') {

            $users = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))->get();

            $att = Attendance::where('course_id', $this->course_id)
                ->whereDate('date', $this->date)
                ->get()
                ->keyBy('teacher_id');
        } else {

            $users = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))
                ->when($this->class_id, fn($q) => $q->where('class_id', $this->class_id))
                ->get();

            $att = Attendance::where('course_id', $this->course_id)
                ->whereDate('date', $this->date)
                ->when($this->class_id, fn($q) => $q->where('class_id', $this->class_id))
                ->get()
                ->keyBy('student_id');
        }

        $rows = [];

        foreach ($users as $u) {
            $a = $att[$u->id] ?? null;

            $rows[] = [
                'Nama' => $u->name,
                'Status' => $a->status ?? '-',
                'Tanggal' => $this->date,
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Nama', 'Status', 'Tanggal'];
    }
}
