<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $role = Role::where('name', 'Guru')->first();

        for ($i = 1; $i <= 3; $i++) {
            $teacher = User::create([
                'name' => "Guru $i",
                'email' => "guru$i@gmail.com",
                'password' => Hash::make('password'),
            ]);

            $teacher->roles()->attach($role->id);
        }
    }
}
