<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
   public function dashboard()
{
    try {
        // Get counts for dashboard stats
        $totalStudents = User::where('role', 'student')->count();
        $totalLecturers = User::where('role', 'lecturer')->count();
        $totalCourses = Course::count();
        $totalAttendances = Attendance::count();
        $totalClassesAttended = $totalAttendances;

        // Get recent activities
        $recentStudents = User::where('role', 'student')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentCourses = Course::with('lecturer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent attendances
        $recentAttendances = Attendance::with(['student', 'course'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalStudents' => $totalStudents,
            'totalLecturers' => $totalLecturers,
            'totalCourses' => $totalCourses,
            'totalAttendances' => $totalAttendances,
            'totalClassesAttended' => $totalClassesAttended,
            'recentStudents' => $recentStudents,
            'recentCourses' => $recentCourses,
            'recentAttendances' => $recentAttendances // Add this line
        ]);

    } catch (\Exception $e) {
        // Fallback if there are any errors
        return view('admin.dashboard', [
            'totalStudents' => 0,
            'totalLecturers' => 0,
            'totalCourses' => 0,
            'totalAttendances' => 0,
            'totalClassesAttended' => 0,
            'recentStudents' => collect(),
            'recentCourses' => collect(),
            'recentAttendances' => collect()
        ]);
    }
}
    // Student Management
    public function students()
{
    $students = User::where('role', 'student')->get();
    return view('admin.students', compact('students'));
}

    public function createStudent()
    {
        return view('admin.students.create');
    }

    public function storeStudent(Request $request)
{
    // DEBUG: Log the request
    \Log::info('=== STUDENT FORM SUBMISSION ===');
    \Log::info('Form data:', $request->all());
    
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        \Log::info('Validation passed, creating student...');
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student'
        ]);

        \Log::info('SUCCESS: Student created with ID: ' . $user->id);
        
        return redirect()->route('admin.students')->with('success', 'Student added successfully!');
        
    } catch (\Exception $e) {
        \Log::error('ERROR creating student: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    // Lecturer Management
    public function lecturers()
    {
        $lecturers = User::where('role', 'lecturer')->with('coursesTeaching')->get(); // Fixed
        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function createLecturer()
    {
        return view('admin.lecturers.create');
    }

    public function storeLecturer(Request $request)
{
    // DEBUG: Log the request
    \Log::info('=== LECTURER FORM SUBMISSION ===');
    \Log::info('Form data:', $request->all());
    
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        \Log::info('Validation passed, creating lecturer...');
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'lecturer'
        ]);

        \Log::info('SUCCESS: Lecturer created with ID: ' . $user->id);
        
        return redirect()->route('admin.lecturers')->with('success', 'Lecturer added successfully!');
        
    } catch (\Exception $e) {
        \Log::error('ERROR creating lecturer: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    // Course Management
   public function courses()
{
    $courses = Course::all();
    $lecturers = User::where('role', 'lecturer')->get();
    return view('admin.courses', compact('courses', 'lecturers'));
}

   public function storeCourse(Request $request)
{
    $request->validate([
        'course_code' => 'required|string|unique:courses',
        'course_name' => 'required|string|max:255',  // Changed from 'name' to 'course_name'
        'description' => 'nullable|string',
        'lecturer_id' => 'required|exists:users,id'
    ]);

    Course::create([
        'course_code' => $request->course_code,
        'course_name' => $request->course_name,      // Changed from 'name' to 'course_name'
        'description' => $request->description,
        'lecturer_id' => $request->lecturer_id
    ]);

    return redirect()->route('admin.courses')->with('success', 'Course added successfully!');
}
    public function assignStudents(Course $course, Request $request)
{
    $request->validate([
        'students' => 'required|array',
        'students.*' => 'exists:users,id'
    ]);

    $course->students()->sync($request->students);

    return redirect()->back()->with('success', 'Students assigned successfully!');
}

    // Attendance Reports
    public function attendanceReports()
    {
      // If you have a different date column like 'attendance_date':
    $attendances = Attendance::with('student', 'session.course')
        ->orderBy('attendance_date', 'desc') // Change to your actual column name
        ->latest() // Remove this if using specific column ordering
        ->get();
    
    return view('admin.reports.attendance', compact('attendances'));}
}