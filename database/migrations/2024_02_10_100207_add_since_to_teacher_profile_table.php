<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSinceToTeacherProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_profile', function (Blueprint $table) {
            $table->string('since')->nullable()->after('degree_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_profile', function (Blueprint $table) {
            $table->string('since')->nullable()->after('degree_from');
        });
    }
}
