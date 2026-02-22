<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class QuizTestSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 1️⃣ Buat user siswa
        $userId = DB::table('users')->insertGetId([
            'name' => 'Siswa Test',
            'email' => 'siswa@test.com',
            'password' => Hash::make('123456'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2️⃣ Buat quiz
        $quizId = DB::table('quizzes')->insertGetId([
            'class_id' => 1, // pastikan kelas ada
            'title' => 'Quiz Matematika',
            'description' => 'Quiz contoh untuk testing',
            'duration' => 30,
            'due_date' => $now->copy()->addDay(),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3️⃣ Buat pertanyaan PG
        $questionPgId = DB::table('questions')->insertGetId([
            'quiz_id' => $quizId,
            'question_text' => '2 + 2 = ?',
            'is_essay' => 0,
            'correct_answer' => 'B',
            'score_correct' => 10,
            'score_incorrect' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4️⃣ Buat pertanyaan essay
        $questionEssayId = DB::table('questions')->insertGetId([
            'quiz_id' => $quizId,
            'question_text' => 'Jelaskan konsep Pythagoras',
            'is_essay' => 1,
            'score_correct' => 20,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 5️⃣ Buat submission siswa dengan jawaban
        $answers = [
            $questionPgId => 'B',          // jawaban PG
            'essay_scores' => [
                $questionEssayId => 15     // nilai essay
            ]
        ];

        DB::table('quiz_submissions')->insert([
            'quiz_id' => $quizId,
            'class_id' => 1,
            'user_id' => $userId,
            'answers' => json_encode($answers),
            'is_submitted' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
