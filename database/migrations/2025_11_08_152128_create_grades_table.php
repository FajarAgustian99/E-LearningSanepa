<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->index(); // relasi ke tabel users
            $table->unsignedBigInteger('teacher_id')->nullable()->index(); // relasi ke user guru
            $table->unsignedBigInteger('class_id')->nullable()->index(); // opsional, untuk tahu kelasnya

            $table->decimal('rekap_absensi', 5, 2)->nullable();
            $table->decimal('lingkup_materi_1', 5, 2)->nullable();
            $table->decimal('lingkup_materi_2', 5, 2)->nullable();
            $table->decimal('lingkup_materi_3', 5, 2)->nullable();
            $table->decimal('lingkup_materi_4', 5, 2)->nullable();
            $table->decimal('sumatif_akhir_semester', 5, 2)->nullable();
            $table->decimal('uhb', 5, 2)->nullable();
            $table->decimal('psat', 5, 2)->nullable();
            $table->decimal('na', 5, 2)->nullable();
            $table->string('kktp', 100)->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');
        });
    }

    /**
     * Undo migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
