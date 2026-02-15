<?php
// routes/web.php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// ====================
// PUBLIC ROUTES
// ====================

// Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login.form');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// QR Code Scanning (Public - for students to scan)
Route::post('/attendance/scan/{token}', function ($token) {
    \Log::info('🔍 Scanning QR token: ' . $token);

    try {
        // Check if token exists and is valid
        $qrCode = DB::table('qr_codes')
            ->where('token', $token)
            ->where('is_used', 0)
            ->first();

        if (!$qrCode) {
            \Log::warning('Invalid or used token: ' . $token);
            return response()->json(['error' => 'Invalid or used token'], 400);
        }

        // 🔑 FIND SESSION using token
        $session = Session::where('attendance_token', $token)->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $attendanceId = DB::table('attendance')->insertGetId([
    'student_id' => $qrCode->student_id,            
    'class_session_id' => $session->id,             
    'course_id' => $session->course_id,           // required
    'session_id' => $session->id,                  // required
    'attendance_token' => rand(100000,999999),    // required, integer
    'qr_code_data' => Str::random(20),            // required
    'status' => 'present',                         // optional (default exists)
    'qr_token' => $token,                          // required
    'scanned_at' => now(),                         // required
    'created_at' => now(),
    'updated_at' => now(),
]);


        // Mark QR code as used
        DB::table('qr_codes')
            ->where('token', $token)
            ->update(['is_used' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully',
            'attendance_id' => $attendanceId
        ]);

    } catch (\Exception $e) {
        \Log::error('Server error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('attendance.scan');

// Debug/Test Routes (Public)
Route::get('/test-attendance', function() {
    try {
        $test = DB::table('qr_codes')->first();
        return "Database connected! QR codes: " . ($test ? 'Exists' : 'Empty');
    } catch (\Exception $e) {
        return "Database error: " . $e->getMessage();
    }
});

Route::get('/debug-scan', function() {
    try {
        $test = DB::table('qr_sessions')->first();
        $qrCode = 'tQyXvnpyN00Y2gY1LePDpWMuIPQiKZRV';
        $session = DB::table('qr_sessions')
                    ->where('qr_code', $qrCode)
                    ->first();
        
        return [
            'database_connected' => $test ? 'Yes' : 'No tables',
            'qr_code_exists' => $session ? 'Yes' : 'No',
            'qr_code' => $qrCode,
            'tables' => DB::select('SHOW TABLES')
        ];
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/test-attendance-table', function() {
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('attendance');
    dd($columns);
});

// ====================
// PROTECTED ROUTES (Require Authentication)
// ====================
Route::middleware(['auth'])->group(function () {
    
    // --------------------
    // ADMIN ROUTES
    // --------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Students
        Route::get('/students', [AdminController::class, 'students'])->name('students');
        Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
        Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
        
        // Lecturers
        Route::get('/lecturers', [AdminController::class, 'lecturers'])->name('lecturers');
        Route::get('/lecturers/create', [AdminController::class, 'createLecturer'])->name('lecturers.create');
        Route::post('/lecturers', [AdminController::class, 'storeLecturer'])->name('lecturers.store');
        
        // Courses
        Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
        Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
        Route::post('/courses/{course}/assign-students', [AdminController::class, 'assignStudents'])->name('courses.assign-students');
        
        // Reports
        Route::get('/reports/attendance', [AdminController::class, 'attendanceReports'])->name('reports.attendance');
    });

    // --------------------
    // LECTURER ROUTES - FIXED (Removed 'role:lecturer' middleware)
    // --------------------
    Route::prefix('lecturer')->name('lecturer.')->group(function () {
        Route::get('/dashboard', [LecturerController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [LecturerController::class, 'courses'])->name('courses');
        
        // Sessions (Fixed - using SessionController)
        Route::get('/courses/{course}/sessions/create', [SessionController::class, 'create'])->name('sessions.create');
        Route::post('/courses/{course}/sessions', [SessionController::class, 'store'])->name('sessions.store');
        Route::get('/sessions/{session}', [SessionController::class, 'show'])->name('sessions.show');
        
        // Alternative LecturerController routes (keep if you need them)
        Route::post('/courses/{course}/generate-qr-session', [LecturerController::class, 'generateQRSession'])->name('generate-qr-session');
        
        // Reports
        Route::get('/reports/attendance', [LecturerController::class, 'attendanceReports'])->name('reports.attendance');
    });

    // --------------------
    // STUDENT ROUTES
    // --------------------
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
        Route::get('/attendance', [StudentController::class, 'attendanceRecords'])->name('attendance');
        Route::get('/attendance/records', [StudentController::class, 'attendanceRecords'])->name('attendance.records');
        Route::get('/scan', [StudentController::class, 'scanQR'])->name('scan');
        Route::post('/process-qr', [StudentController::class, 'processQR'])->name('process-qr');
        Route::post('/attendance/mark', [StudentController::class, 'markAttendance'])->name('attendance.mark');
    });

    // --------------------
    // QR CODE ROUTE
    // --------------------
    Route::get('/attendance/scan/{qrCode}', [QRCodeController::class, 'scan'])->name('attendance.scan');
});
Route::get('/debug-attendance-table', function() {
    try {
        // Check table name
        $tableExists = \Illuminate\Support\Facades\Schema::hasTable('attendance');
        $tablesPluralExists = \Illuminate\Support\Facades\Schema::hasTable('attendances');
        
        // Get columns for both possibilities
        $columnsAttendance = $tableExists ? 
            \Illuminate\Support\Facades\Schema::getColumnListing('attendance') : [];
        
        $columnsAttendances = $tablesPluralExists ? 
            \Illuminate\Support\Facades\Schema::getColumnListing('attendances') : [];
        
        return response()->json([
            'table_attendance_exists' => $tableExists,
            'table_attendances_exists' => $tablesPluralExists,
            'columns_attendance' => $columnsAttendance,
            'columns_attendances' => $columnsAttendances,
            'model_using' => \App\Models\Attendance::make()->getTable()
        ]);
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
Route::get('/check-tables', function() {
    $tables = DB::select('SHOW TABLES');
    return response()->json($tables);
});
Route::post('/debug-qr-test', function(Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Debug endpoint working',
        'request_data' => $request->all(),
        'headers' => $request->headers->all(),
        'content_type' => $request->header('Content-Type'),
        'is_json' => $request->isJson(),
        'has_qr_code' => $request->has('qr_code'),
        'qr_code_value' => $request->input('qr_code')
    ]);
});

 