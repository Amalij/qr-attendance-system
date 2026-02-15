<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'student_id',
        'session_id',
        'class_session_id',
        'attendance_token',
        'qr_token',
        'qr_code_data',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime', // ensures ->format() works
    ];

    // Relationship to Session
    public function session()
    {
        return $this->belongsTo(\App\Models\Session::class);
    }

    // Relationship to Student (User)
    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id');
    }
}
