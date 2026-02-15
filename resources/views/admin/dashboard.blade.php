@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Welcome back, Admin</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">Here's what's happening with your system today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Total Students -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">04</p>
                        <div class="flex items-center mt-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Active</span>
                        </div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 rounded-xl">
                        <i class="fas fa-users text-blue-500 dark:text-blue-400 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.students') }}" class="text-sm text-blue-500 dark:text-blue-400 hover:text-blue-600 dark:hover:text-blue-300 font-medium flex items-center">
                        View all <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Total Lecturers -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Lecturers</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">06</p>
                        <div class="flex items-center mt-2">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Teaching</span>
                        </div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/20 rounded-xl">
                        <i class="fas fa-chalkboard-teacher text-purple-500 dark:text-purple-400 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.lecturers') }}" class="text-sm text-purple-500 dark:text-purple-400 hover:text-purple-600 dark:hover:text-purple-300 font-medium flex items-center">
                        View all <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Total Courses -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Courses</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">04</p>
                        <div class="flex items-center mt-2">
                            <span class="w-2 h-2 bg-pink-500 rounded-full mr-2"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Running</span>
                        </div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900/30 dark:to-pink-800/20 rounded-xl">
                        <i class="fas fa-book-open text-pink-500 dark:text-pink-400 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.courses') }}" class="text-sm text-pink-500 dark:text-pink-400 hover:text-pink-600 dark:hover:text-pink-300 font-medium flex items-center">
                        View all <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Total Attendances -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's Attendances</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">02</p>
                        <div class="flex items-center mt-2">
                            <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Today</span>
                        </div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/20 rounded-xl">
                        <i class="fas fa-clipboard-check text-indigo-500 dark:text-indigo-400 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.reports.attendance') }}" class="text-sm text-indigo-500 dark:text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 font-medium flex items-center">
                        View reports <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-10">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.students') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 text-center border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-300">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-plus text-blue-500 dark:text-blue-400 text-xl"></i>
                    </div>
                    <p class="font-semibold text-gray-800 dark:text-white">Add Student</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Register new student</p>
                </a>

                <a href="{{ route('admin.lecturers') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 text-center border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-purple-300 dark:hover:border-purple-500 transition-all duration-300">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-lg mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chalkboard-teacher text-purple-500 dark:text-purple-400 text-xl"></i>
                    </div>
                    <p class="font-semibold text-gray-800 dark:text-white">Add Lecturer</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Register new lecturer</p>
                </a>

                <a href="{{ route('admin.courses') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 text-center border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-pink-300 dark:hover:border-pink-500 transition-all duration-300">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900/30 dark:to-pink-800/30 rounded-lg mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-book-medical text-pink-500 dark:text-pink-400 text-xl"></i>
                    </div>
                    <p class="font-semibold text-gray-800 dark:text-white">Add Course</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Create new course</p>
                </a>

                <a href="{{ route('admin.reports.attendance') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 text-center border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-500 transition-all duration-300">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/30 rounded-lg mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-bar text-indigo-500 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <p class="font-semibold text-gray-800 dark:text-white">View Reports</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Analytics & insights</p>
                </a>
            </div>
        </div>

        <!-- Recent Activities Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Students -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Recent Students</h2>
                        <a href="{{ route('admin.students') }}" class="text-sm font-medium text-blue-500 dark:text-blue-400 hover:text-blue-600 dark:hover:text-blue-300">
                            View All
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentStudents->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentStudents as $student)
                            <div class="flex items-center p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 border border-gray-100 dark:border-gray-700">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user text-blue-500 dark:text-blue-300 text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $student->name }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $student->email }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Joined</p>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $student->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                <i class="fas fa-users text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">No students registered yet</p>
                            <a href="{{ route('admin.students') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
                                <i class="fas fa-plus mr-2"></i>
                                Add First Student
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Courses -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Recent Courses</h2>
                        <a href="{{ route('admin.courses') }}" class="text-sm font-medium text-purple-500 dark:text-purple-400 hover:text-purple-600 dark:hover:text-purple-300">
                            View All
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentCourses->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentCourses as $course)
                            <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-purple-200 dark:hover:border-purple-500 hover:bg-purple-50/50 dark:hover:bg-purple-900/10 transition-all duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900 dark:to-pink-800 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-book text-purple-500 dark:text-purple-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-800 dark:text-white">{{ $course->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 truncate">{{ $course->description ?? 'No description' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center mt-3 text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-user-tie mr-2 text-purple-500"></i>
                                            {{ $course->lecturer->name ?? 'No Lecturer' }}
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 text-purple-600 dark:text-purple-300">
                                        Active
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                <i class="fas fa-book-open text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">No courses created yet</p>
                            <a href="{{ route('admin.courses') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg font-medium hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
                                <i class="fas fa-plus mr-2"></i>
                                Create First Course
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="mt-10">
            <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 dark:from-blue-500/5 dark:to-purple-500/5 rounded-2xl p-8 border border-blue-100 dark:border-blue-900/30">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">System Status</h3>
                        <p class="text-gray-600 dark:text-gray-300">All systems operational • Last updated: Today, {{ now()->format('g:i A') }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-500">{{ $recentStudents->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">New Students</div>
                        </div>
                        <div class="h-8 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-500">{{ $recentCourses->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">New Courses</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 4px;
    }
    
    .dark ::-webkit-scrollbar-track {
        background: #374151;
    }
    
    .dark ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Card hover effects */
    .hover-lift:hover {
        transform: translateY(-4px);
    }
    
    /* Gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endpush
@endsection