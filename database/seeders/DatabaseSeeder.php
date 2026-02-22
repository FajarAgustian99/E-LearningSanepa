<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Classes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate semua tabel terkait
        // DB::table('grades')->truncate();
        DB::table('submissions')->truncate();
        DB::table('assignments')->truncate();
        DB::table('enrollments')->truncate();
        DB::table('sessions')->truncate();

        Course::truncate();
        Classes::truncate();
        User::truncate();
        Role::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ================= ROLES =================
        $admin = Role::create(['name' => 'Admin']);
        $guru  = Role::create(['name' => 'Guru']);
        $siswa = Role::create(['name' => 'Siswa']);

        // ================= ADMIN =================
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sanepa.test',
            'password' => Hash::make('password'),
            'role_id' => $admin->id
        ]);

        // ================= GURU =================
        $teachers = [];

        for ($i = 1; $i <= 3; $i++) {
            $teachers[] = User::create([
                'name' => "Guru $i",
                'email' => "guru{$i}@sanepa.test",
                'password' => Hash::make('password'),
                'role_id' => $guru->id
            ]);
        }

        // ================= CLASS =================
        $classes = [];

        $classes[] = Classes::create(['name' => 'X IPA 1', 'teacher_id' => $teachers[0]->id]);
        $classes[] = Classes::create(['name' => 'X IPA 2', 'teacher_id' => $teachers[1]->id]);
        $classes[] = Classes::create(['name' => 'X IPS 1', 'teacher_id' => $teachers[2]->id]);

        // ================= SISWA =================
        $students = [];

        for ($i = 1; $i <= 10; $i++) {

            $class = $classes[array_rand($classes)];

            $students[] = User::create([
                'name' => "Siswa $i",
                'email' => "siswa{$i}@sanepa.test",
                'password' => Hash::make('password'),
                'role_id' => $siswa->id,
                'class_id' => $class->id,
            ]);
        }

        // ================= COURSE =================
        $courseTitles = ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'Bahasa Inggris'];

        foreach ($courseTitles as $i => $title) {

            $teacher = $teachers[$i % count($teachers)];
            $class   = $classes[$i % count($classes)];

            Course::create([
                'title' => $title,
                'description' => "Deskripsi $title",
                'teacher_id' => $teacher->id,
                'class_id' => $class->id,
                'image' => null,
            ]);
        }

        // ================= ENROLLMENTS =================
        foreach ($students as $s) {
            DB::table('enrollments')->insert([
                'class_id' => $s->class_id,
                'user_id' => $s->id,
                'enrolled_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
