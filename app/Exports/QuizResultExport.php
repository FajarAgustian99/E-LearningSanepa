<?php

namespace App\Exports;

use App\Models\Quiz;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuizResultExport implements FromCollection, WithHeadings
{
    protected $quiz;

    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function collection()
    {
        return $this->quiz->submissions->map(function ($submission, $index) {
            return [
                'No'          => $index + 1,
                'Nama Siswa'  => $submission->user->name,
                'Nilai'       => $submission->score ?? 0,
                'Status'      => $submission->is_submitted ? 'Selesai' : 'Belum',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Nilai',
            'Status',
        ];
    }
}
