<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('attendance_token', 64)->unique()->nullable(); // For QR code scanning
            $table->string('qr_code', 64)->nullable(); // For backward compatibility
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();
            
            $table->index('attendance_token');
            $table->index('course_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};