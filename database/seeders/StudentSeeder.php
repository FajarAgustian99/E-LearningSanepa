<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $role = Role::where('name', 'Siswa')->first();

        for ($i = 1; $i <= 10; $i++) {
            $student = User::create([
                'name' => "Siswa $i",
                'email' => "siswa$i@gmail.com",
                'password' => Hash::make('password'),
            ]);

            $student->roles()->attach($role->id);
        }
    }
}
