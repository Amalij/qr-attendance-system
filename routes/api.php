<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::post('/attendance/scan/{token}', function ($token) {
    \Log::info('🔍 Scanning QR token: ' . $token);
    
    try {
        // 1. Check if token exists and is valid
        $qrCode = DB::table('qr_codes')
                    ->where('token', $token)
                    ->where('is_used', 0)
                    ->first();
        
        if (!$qrCode) {
            \Log::warning('Invalid or used token: ' . $token);
            return response()->json(['error' => 'Invalid or used token'], 400);
        }
        
        \Log::info('Valid token found for student: ' . $qrCode->student_id);
        
        // 2. Insert attendance record
        $attendanceId = DB::table('attendance')->insertGetId([
            'student_id' => $qrCode->student_id,
            'qr_token' => $token,
            'scanned_at' => now()
        ]);
        
        \Log::info('Attendance inserted with ID: ' . $attendanceId);
        
        // 3. Mark QR code as used
        DB::table('qr_codes')
            ->where('token', $token)
            ->update(['is_used' => 1]);
        
        \Log::info('QR code marked as used');
        
        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully',
            'studentId' => $qrCode->student_id
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Server error: ' . $e->getMessage());
        return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
    }
});