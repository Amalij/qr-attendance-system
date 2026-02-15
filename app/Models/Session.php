<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;

    // Explicitly set table name if needed
    protected $table = 'sessions';

    protected $fillable = [
        'course_id',
        'attendance_token',
        'qr_code',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship with Attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Check if session is active
    // In Session.php model
public function isActive()
{
    return now()->between($this->start_time, $this->end_time);
}

    // Generate QR code data
    public function getQrCodeDataAttribute()
    {
        return $this->attendance_token ?? $this->qr_code;
    }
}