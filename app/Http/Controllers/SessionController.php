<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Session;
use App\Models\Attendance;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    // Show create form
    public function create(Course $course)
    {
        return view('lecturer.sessions.create', compact('course'));
    }

    // Store new session and generate QR
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'duration' => 'required|integer|min:5|max:240'
        ]);

        // FIX: Convert duration to integer
        $duration = (int) $request->duration;

        // Create session
        $session = Session::create([
            'course_id' => $course->id,
            'duration_minutes' => $duration,
            'start_time' => now(),
            'end_time' => now()->addMinutes($duration), // FIXED: Now using integer
            'attendance_token' => Str::random(32), // Unique token for QR
            'qr_code' => Str::random(20),
            'status' => 'active', // Add status field
        ]);

        return redirect()->route('lecturer.sessions.show', $session);
    }

    // Show session with QR code
   // app/Http/Controllers/SessionController.php
public function show(Session $session)
{
    // Generate QR code
    $attendanceUrl = url('/attendance/scan/' . $session->attendance_token);
    $qrCodeSvg = QrCode::size(300)->generate($attendanceUrl);

    // Get attendance records - using qr_token column
    $attendances = DB::table('attendance')
        ->where('qr_token', $session->attendance_token) // Use qr_token column
        ->join('users', 'attendance.student_id', '=', 'users.id')
        ->select('attendance.*', 'users.name as student_name')
        ->get();

    return view('lecturer.sessions.show', compact('session', 'qrCodeSvg', 'attendances'));
}}