<?php

namespace App\Exports;

use App\Models\Grade;
use App\Models\Classes;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class GradesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $classId;
    protected $courseId;
    protected $class;
    protected $course;

    public function __construct($classId, $courseId)
    {
        $this->classId  = $classId;
        $this->courseId = $courseId;
        $this->class  = Classes::find($classId);
        $this->course = Course::find($courseId);
    }

    public function collection()
    {
        return Grade::with('student')
            ->where('class_id', $this->classId)
            ->where('course_id', $this->courseId)
            ->get()
            ->map(function ($g) {
                return [
                    $g->student->name ?? '-',
                    $g->rekap_absensi,
                    $g->lingkup_materi_1,
                    $g->lingkup_materi_2,
                    $g->lingkup_materi_3,
                    $g->lingkup_materi_4,
                    $g->sumatif_akhir_semester,
                    $g->uhb,
                    $g->psat,
                    $g->na,
                    $g->kktp,
                ];
            });
    }

    // Header tabel (mulai baris 5)
    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Absensi',
            'LM 1',
            'LM 2',
            'LM 3',
            'LM 4',
            'Sumatif',
            'UHB',
            'PSAT',
            'NA',
            'KKTP',
        ];
    }

    // Tabel mulai dari A5
    public function startCell(): string
    {
        return 'A5';
    }

    // Header tambahan
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->setCellValue('A1', 'LAPORAN NILAI SISWA');
                $sheet->setCellValue('A2', 'Kelas : ' . ($this->class->name ?? '-'));
                $sheet->setCellValue('A3', 'Mata Pelajaran : ' . ($this->course->title ?? '-'));

                $sheet->mergeCells('A1:K1');
                $sheet->mergeCells('A2:K2');
                $sheet->mergeCells('A3:K3');

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1:A3')->getFont()->setBold(true);
            },
        ];
    }
}
