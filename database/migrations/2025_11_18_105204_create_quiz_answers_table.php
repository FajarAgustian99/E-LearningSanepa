<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('submission_id')
                ->constrained('quiz_submissions')
                ->onDelete('cascade');

            $table->foreignId('question_id')
                ->constrained('questions')
                ->onDelete('cascade');

            // Jawaban siswa
            $table->text('answer_text')->nullable();
            $table->string('selected_option', 10)->nullable();

            // Penilaian
            $table->boolean('is_correct')->nullable(); // null = belum dinilai
            $table->integer('score')->nullable();      // skor per soal

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};
