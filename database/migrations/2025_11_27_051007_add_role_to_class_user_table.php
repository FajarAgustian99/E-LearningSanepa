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
        Schema::table('class_user', function (Blueprint $table) {
            $table->string('role')->default('student')->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('class_user', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
