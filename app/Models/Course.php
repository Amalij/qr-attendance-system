<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'course_name',
        'description',
        'lecturer_id'
    ];

    // Relationship with Lecturer
    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    // Relationship with Students (many-to-many)
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id')
                    ->withTimestamps();
    }

    // Relationship with Sessions
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}