@extends('layouts.app')

@section('title', 'Create Session')

@section('content')
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Create New Session</h1>
    <p class="text-gray-600">Course: {{ $course->course_name }} ({{ $course->course_code }})</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-md">
    <form action="{{ route('lecturer.sessions.store', $course) }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Session Duration (minutes)</label>
            <select name="duration" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="15">15 minutes</option>
                <option value="30" selected>30 minutes</option>
                <option value="45">45 minutes</option>
                <option value="60">60 minutes</option>
                <option value="120">2 hours</option>
            </select>
            <p class="text-sm text-gray-500 mt-1">How long the QR code will be valid</p>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-qrcode mr-2"></i>Start Session & Generate QR Code
            </button>
            <a href="{{ route('lecturer.courses') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Cancel
            </a>
        </div>
    </form>
</div>


@endsection