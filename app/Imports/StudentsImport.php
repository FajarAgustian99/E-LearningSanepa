<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Classes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $validator = Validator::make($row->toArray(), [
                'name'  => 'required|string|max:255',
                'nisn'  => 'required|numeric',
                'kelas' => 'required|exists:classes,name',
            ]);

            if ($validator->fails()) {
                continue;
            }

            $class = Classes::where('name', $row['kelas'])->first();
            if (!$class) {
                continue;
            }

            $student = User::firstOrCreate(
                ['nisn' => $row['nisn']],
                [
                    'name'     => $row['name'],
                    'password' => Hash::make($row['password'] ?? $row['nisn']),
                    'role_id'  => 3,
                ]
            );

            // 🔥 INI YANG DIPERBAIKI
            $student->class_id = $class->id;
            $student->save();
        }
    }
}
