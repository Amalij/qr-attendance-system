<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Attendance;

class QRCodeController extends Controller
{
    public function scan($qrCode)
    {
        \Log::info('🔍 Scanning QR code: ' . $qrCode);

        try {
            // 1. Find the session by QR code and check if it is not expired
            $session = Session::where('qr_code', $qrCode)
                ->where('expires_at', '>', now())
                ->first();

            if (!$session) {
                return response()->json(['error' => 'Invalid or expired QR code'], 400);
            }

            // 2. Check if the student is enrolled in the course
            $enrolled = $session->students()->where('student_id', auth()->id())->exists();

            if (!$enrolled) {
                return response()->json(['error' => 'You are not enrolled in this course'], 400);
            }

            // 3. Check if attendance already exists
            $alreadyMarked = Attendance::where('student_id', auth()->id())
                ->where('session_id', $session->id)
                ->exists();

            if ($alreadyMarked) {
                return response()->json(['error' => 'Attendance already marked'], 400);
            }

            // 4. Mark attendance
            $attendance = Attendance::create([
                'student_id' => auth()->id(),
                'session_id' => $session->id,
                'scanned_at' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance marked successfully',
                'course' => $session->course_id,
                'attendance_id' => $attendance->id,
            ]);

        } catch (\Exception $e) {
            \Log::error('Scan error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
