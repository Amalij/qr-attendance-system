@extends('layouts.app')

@section('title', 'Attendance Reports')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Attendance Reports</h1>
</div>

@foreach($courses as $course)
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-bold">{{ $course->course_name }} ({{ $course->course_code }})</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students Present</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance Rate</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($course->sessions as $session)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $session->start_time->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $session->attendances->count() }} / {{ $course->students->count() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @php
                            $totalStudents = $course->students->count();
                            $present = $session->attendances->count();
                            $rate = $totalStudents > 0 ? round(($present / $totalStudents) * 100, 1) : 0;
                        @endphp
                        {{ $rate }}%
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                        No sessions conducted for this course.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
     <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
</div>
@endforeach
@endsection