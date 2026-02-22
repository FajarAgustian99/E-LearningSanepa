<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->string('kktp', 50)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->integer('kktp')->nullable()->change(); // sesuaikan dengan tipe lama kalau perlu rollback
        });
    }
};
