<?php
// app/Http/Controllers/LecturerController.php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Session;
use App\Models\Attendance;
use App\Models\AttendanceSession; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB; 
use App\Models\User;
class LecturerController extends Controller
{
    public function dashboard()
    {
        $courses = Course::where('lecturer_id', auth()->id())
            ->withCount(['sessions', 'students'])
            ->get();
            
        $totalSessions = $courses->sum('sessions_count');
        $totalStudents = $courses->sum('students_count');

        return view('lecturer.dashboard', compact('courses', 'totalSessions', 'totalStudents'));
    }

    public function courses()
{
    $courses = Course::where('lecturer_id', auth()->id())
        ->with(['students', 'sessions'])
        ->get();

    $allStudents = User::where('role', 'student')->get(); // Fetch all students

    return view('lecturer.courses', compact('courses', 'allStudents'));
}

    public function createSession(Course $course)
    {
        // Check if the course belongs to the lecturer
        if ($course->lecturer_id !== auth()->id()) {
            return redirect()->route('lecturer.courses')->with('error', 'Unauthorized access.');
        }

        return view('lecturer.sessions.create', compact('course'));
    }

    public function storeSession(Request $request, Course $course)
{
    $request->validate([
        'duration' => 'required|integer|min:1|max:240',
    ]);

    // Convert duration to integer
    $duration = (int) $request->duration;

    // Generate unique tokens
    $attendanceToken = Str::random(32);
    $qrCode = Str::random(32); // For backward compatibility

    // Create session
    $session = Session::create([
        'course_id' => $course->id,
        'attendance_token' => $attendanceToken,
        'qr_code' => $qrCode,
        'start_time' => now(),
        'end_time' => now()->addMinutes($duration), // Use the integer value
    ]);

    return redirect()->route('lecturer.sessions.show', $session)
        ->with('success', 'Session created successfully!');
}
   public function showSession($id)
{
    try {
        // Manually find the session from the class_sessions table
        $session = DB::table('class_sessions')
            ->where('id', $id)
            ->first();
        
        if (!$session) {
            abort(404, 'Session not found');
        }
        
        // Convert to object if it's an array
        if (is_array($session)) {
            $session = (object) $session;
        }
        
        // Get attendance records for this session
        // Use the qr_code from the session to match attendance_token
        $attendances = DB::table('attendance')
            ->where('attendance_token', $session->qr_code)
            ->orWhere('qr_token', $session->qr_code)
            ->join('users', 'attendance.student_id', '=', 'users.id')
            ->select('attendance.*', 'users.name as student_name', 'users.email as student_email')
            ->orderBy('scanned_at', 'desc')
            ->get();
        
        // Get the course information
        $course = DB::table('courses')->where('id', $session->course_id)->first();
        
        return view('lecturer.session-show', compact('session', 'attendances', 'course'));
        
    } catch (\Exception $e) {
        return back()->with('error', 'Error loading session: ' . $e->getMessage());
    }
}

    public function attendanceReports()
    {
        $courses = Course::where('lecturer_id', auth()->id())
            ->with(['sessions.attendances.student'])
            ->get();
        return view('lecturer.reports.attendance', compact('courses'));
    }

    // ===> ADD THIS NEW METHOD <===
    public function generateQRSession(Request $request, Course $course)
{
    // Check if the course belongs to the lecturer
    if ($course->lecturer_id !== auth()->id()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access.'
        ], 403);
    }

    $token = Str::random(32);
    
    // Create attendance session
    $attendanceSession = AttendanceSession::create([
        'course_id' => $course->id,
        'lecturer_id' => auth()->id(),
        'token' => $token,
        'is_active' => true,
        'expires_at' => now()->addMinutes(15) // QR valid for 15 minutes
    ]);
    
    // FORCE the correct URL with port 8000
    $qrUrl = 'http://127.0.0.1:8000/attendance/scan/' . $token;
    
    // Log for debugging
    \Log::info('Generated QR URL: ' . $qrUrl);
    
    return response()->json([
        'success' => true,
        'qr_url' => $qrUrl,
        'token' => $token,
        'expires_at' => $attendanceSession->expires_at->format('Y-m-d H:i:s')
    ]);
}}