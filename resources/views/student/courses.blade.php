@extends('layouts.app')

@section('title', 'My Courses')

@section('content')
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">My Courses</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($courses as $course)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-bold mb-2">{{ $course->course_code }}</h3>
        <h4 class="text-lg text-gray-700 mb-3">{{ $course->course_name }}</h4>
        <div class="text-sm text-gray-600 space-y-1">
            <p><strong>Lecturer:</strong> {{ $course->lecturer->name }}</p>
            <p><strong>Enrolled Students:</strong> {{ $course->students->count() }}</p>
            <p><strong>Sessions:</strong> {{ $course->sessions->count() }}</p>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12">
        <i class="fas fa-book text-4xl text-gray-400 mb-3"></i>
        <p class="text-gray-500 text-lg">You are not enrolled in any courses yet.</p>
    </div>
    @endforelse
</div>
@endsection