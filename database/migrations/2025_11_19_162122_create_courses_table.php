<?php
// database/migrations/2024_01_01_000001_create_courses_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('lecturer_id'); // Use unsignedBigInteger instead of foreignId
            $table->timestamps();

            // Add foreign key constraint separately
            $table->foreign('lecturer_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['lecturer_id']);
        });
        Schema::dropIfExists('courses');
    }
}