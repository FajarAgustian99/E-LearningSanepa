<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Contoh Nama', '1234567890', 'rahasia123', 'X 1'],
        ];
    }

    public function headings(): array
    {
        return ['name', 'nisn', 'password', 'kelas'];
    }
}
