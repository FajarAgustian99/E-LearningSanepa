<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;

class StudentMaterialController extends Controller
{
    public function download(Material $material)
    {
        $user = auth()->user();

        // simpan / update pivot
        $user->materials()->syncWithoutDetaching([
            $material->id => ['is_completed' => 1]
        ]);

        return response()->download(storage_path('app/public/' . $material->file));
    }
}
