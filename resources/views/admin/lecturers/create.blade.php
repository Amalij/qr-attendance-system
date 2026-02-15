@extends('layouts.app')

@section('title', 'Add Lecturer')

@section('content')
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Add New Lecturer</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-md">
    <form action="{{ route('admin.lecturers.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
            <input type="text" id="name" name="name" required 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="{{ old('name') }}" placeholder="Enter lecturer name">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" id="email" name="email" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="{{ old('email') }}" placeholder="Enter lecturer email">
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Enter temporary password">
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>Create Lecturer
            </button>
            <a href="{{ route('admin.lecturers') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection