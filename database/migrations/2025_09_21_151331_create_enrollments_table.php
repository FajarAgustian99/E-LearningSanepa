<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // siswa
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamps();
            $table->unique(['class_id', 'user_id']);
        });
    }
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
