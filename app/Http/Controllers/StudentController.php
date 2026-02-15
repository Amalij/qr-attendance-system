<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Attendance;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get student's courses
        $courses = Course::whereHas('students', function($query) use ($user) {
            $query->where('student_id', $user->id);
        })->get();
        
        // FIX: Use scanned_at instead of created_at
        $recentAttendance = DB::table('attendance')
            ->where('student_id', $user->id)
            ->orderBy('scanned_at', 'desc') // Changed from created_at to scanned_at
            ->limit(5)
            ->get();
        
        // Count attendance stats
        $totalAttendance = DB::table('attendance')->where('student_id', $user->id)->count();
        
        // Since you don't have status column, count all as present
        $presentCount = $totalAttendance; // All attendance records are considered present
        
        $attendanceRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;
        
        // Get active sessions for student's courses
        $activeSessions = Session::whereIn('course_id', $courses->pluck('id'))
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->with('course')
            ->get();
        
        return view('student.dashboard', compact(
            'courses', 
            'recentAttendance', 
            'totalAttendance',
            'attendanceRate',
            'activeSessions'
        ));
    }

    public function courses()
    {
        $user = Auth::user();
        
        $courses = Course::whereHas('students', function($query) use ($user) {
            $query->where('student_id', $user->id);
        })->get();
        
        return view('student.courses', compact('courses'));
    }

    public function attendanceRecords()
    {
        $user = Auth::user();

        // Use Eloquent, not DB::table
        $attendances = Attendance::with('session')
            ->where('student_id', $user->id)
            ->orderBy('scanned_at', 'desc')
            ->paginate(10);

        // Get courses for the student
        $courses = Course::whereHas('students', function($query) use ($user) {
            $query->where('student_id', $user->id);
        })->with(['sessions.attendances'])->get();

        return view('student.attendance', compact('attendances', 'courses'));
    }

    public function scanQR()
    {
        return view('student.scan');
    }

   public function processQR(Request $request)
{
    // Log the incoming request for debugging
    \Log::info('QR Request Data:', [
        'all_data' => $request->all(),
        'content_type' => $request->header('Content-Type'),
        'is_json' => $request->isJson(),
        'has_qr_code' => $request->has('qr_code'),
        'qr_code_value' => $request->input('qr_code'),
        'has_token' => $request->has('token'),
        'token_value' => $request->input('token')
    ]);
    
    // Try to get the QR code from different possible field names
    $qrToken = $request->input('qr_code') ?? $request->input('token') ?? $request->input('qr_token');
    
    // If it's JSON request, decode it
    if ($request->isJson() && !$qrToken) {
        $jsonData = $request->json()->all();
        $qrToken = $jsonData['qr_code'] ?? $jsonData['token'] ?? null;
    }
    
    // Validate
    if (!$qrToken) {
        return response()->json([
            'success' => false,
            'message' => 'QR code token is required.'
        ], 400);
    }
    
    $user = Auth::user();
    
    \Log::info('QR Scan Attempt', [
        'user_id' => $user->id,
        'qr_token' => $qrToken
    ]);
    
    // Find active session
    $session = Session::where('attendance_token', $qrToken)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->first();
    
    if (!$session) {
        \Log::warning('Invalid QR token', ['token' => $qrToken]);
        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired QR code.'
        ], 400);
    }
    
    // Check if already attended
    $existing = DB::table('attendance')
        ->where('student_id', $user->id)
        ->where('qr_token', $qrToken)
        ->exists();
    
    if ($existing) {
        \Log::warning('Duplicate attendance attempt', [
            'user_id' => $user->id,
            'session_id' => $session->id
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Attendance already marked for this session.'
        ], 400);
    }
    
    // Mark attendance
    DB::table('attendance')->insert([
        'student_id' => $user->id,
        'attendance_token' => $session->attendance_token,
        'qr_token' => $qrToken,
        'qr_code_data' => $session->qr_code,
        'scanned_at' => now()
    ]);
    
    \Log::info('Attendance marked successfully', [
        'user_id' => $user->id,
        'session_id' => $session->id
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Attendance marked successfully!'
    ]);
}

public function markAttendance(Request $request)
{
    $request->validate([
        'token' => 'required|string'
    ]);

    $user = Auth::user();

    $session = Session::where('attendance_token', $request->token)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->first();

    if (!$session) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired QR code.'
        ], 400);
    }

    // Already attended?
    $existing = Attendance::where('student_id', $user->id)
        ->where('qr_token', $request->token)
        ->exists();

    if ($existing) {
        return response()->json([
            'success' => false,
            'message' => 'Attendance already marked for this session.'
        ], 400);
    }

    Attendance::create([
        'student_id' => $user->id,
        'session_id' => $session->id,
        'attendance_token' => $session->attendance_token,
        'qr_token' => $request->token,
        'qr_code_data' => $session->qr_code,
        'scanned_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Attendance marked successfully!'
    ]);
}
}