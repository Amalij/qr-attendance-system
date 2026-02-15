@extends('layouts.app')

@section('title', 'Session QR Code')

@section('content')
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Session QR Code</h1>

    <p class="text-gray-600">
        Course: {{ $session->course->course_name }}
        ({{ $session->course->course_code }})
    </p>

    <p class="text-gray-600">
        Valid from:
        {{ \Carbon\Carbon::now('Asia/Colombo')->format('M d, Y H:i') }}
        to
        {{ $session->end_time->setTimezone('Asia/Colombo')->format('M d, Y H:i') }}
    </p>

    <p class="text-sm text-{{ $session->isActive() ? 'green' : 'red' }}-600">
        Status: {{ $session->isActive() ? 'Active' : 'Expired' }}
    </p>
</div>



<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
   <!-- Replace the QR code section with this -->
<div class="bg-white rounded-lg shadow p-6 text-center">
    <h3 class="text-xl font-bold mb-4">QR Code for Attendance</h3>
    
    <!-- QR Code Display -->
    <div class="flex justify-center mb-4 p-4 bg-white border rounded-lg" id="qrcode-container">
        @if(isset($qrCodeSvg) && $qrCodeSvg)
            {!! $qrCodeSvg !!}
        @else
            <div class="text-red-500 p-4">
                <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                <p>QR Code could not be generated</p>
            </div>
        @endif
    </div>
    
    <!-- Debug info -->
    <div class="mt-4 p-3 bg-yellow-50 rounded-lg text-left">
        <p class="text-sm font-bold">Debug Info:</p>
        <p class="text-xs">Session ID: {{ $session->id }}</p>
        <p class="text-xs">Token: {{ $session->attendance_token ?? 'No token' }}</p>
        <p class="text-xs">QR Code Data: {{ isset($qrCodeSvg) ? 'Generated' : 'Not generated' }}</p>
    </div>
</div>
<!-- QR Code URL for manual entry -->
        <div class="bg-gray-50 p-3 rounded-lg">
            <p class="text-xs text-gray-500 mb-1">QR Code Token (for manual entry):</p>
            <p class="text-sm font-mono break-all bg-white p-2 rounded border">
                {{ $session->attendance_token ?? $session->qr_code }}
            </p>
        </div>

        <!-- QR Code URL for scanning -->
        <div class="mt-4 bg-blue-50 p-3 rounded-lg">
            <p class="text-xs text-blue-500 mb-1">Attendance URL:</p>
            <p class="text-sm font-mono break-all bg-white p-2 rounded border">
                {{ url('/attendance/scan/' . ($session->attendance_token ?? $session->qr_code)) }}
            </p>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-bold mb-4">Attendance Records</h3>
        
        @if($attendances->count() > 0)
        <div class="overflow-y-auto max-h-96">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Attendance Time</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($attendances as $attendance)
                    <tr>
                        <td class="px-4 py-2 text-sm">{{ $attendance->student->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-500">
                            {{ $attendance->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($attendance->status ?? 'present') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-users text-3xl mb-3"></i>
            <p>No attendance recorded yet.</p>
        </div>
        @endif
        
        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600">
                Total attended: <strong>{{ $attendances->count() }}</strong> / 
                <strong>{{ $session->course->students->count() ?? 0 }}</strong> students
            </p>
            @php
                $totalStudents = $session->course->students->count() ?? 0;
                $present = $attendances->count();
                $attendanceRate = $totalStudents > 0 ? round(($present / $totalStudents) * 100, 1) : 0;
            @endphp
            <p class="text-sm text-gray-600">
                Attendance rate: <strong>{{ $attendanceRate }}%</strong>
            </p>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="mt-6 flex space-x-4">
    <a href="{{ route('lecturer.courses') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
        Back to Courses
    </a>
    <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-print mr-2"></i>Print QR Code
    </button>
</div>
@endsection