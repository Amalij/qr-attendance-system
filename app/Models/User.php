<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Make sure you have this
        'student_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Student Relationships
    public function studentCourses()
    {
        // If you have a course_student pivot table
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
                    ->withTimestamps();
    }

    // If you have enrollments table
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    // Get courses through enrollments
    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,
            Enrollment::class,
            'student_id', // Foreign key on enrollments table
            'id', // Foreign key on courses table
            'id', // Local key on users table
            'course_id' // Local key on enrollments table
        );
    }

    // Attendance relationship for student
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    // Check if user is student
    public function isStudent()
    {
        return $this->role === 'student';
    }

    // Check if user is lecturer
    public function isLecturer()
    {
        return $this->role === 'lecturer';
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function coursesTeaching()
{
    // Assuming a lecturer has many courses
    return $this->hasMany(Course::class, 'lecturer_id');
}
}