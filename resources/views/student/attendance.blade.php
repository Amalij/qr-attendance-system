@extends('layouts.app')

@section('title', 'Attendance Records')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Attendance Records</h1>
                <p class="text-gray-600">Track and analyze your attendance history</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('student.dashboard') }}" class="group flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium text-gray-700 group-hover:text-blue-700">Back to Dashboard</span>
                </a>
                <button class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Report
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Attendance</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $attendances->count() }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-50">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-green-600 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                    </svg>
                    All-time records
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">This Month</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $attendances->where('scanned_at', '>=', now()->startOfMonth())->count() }}
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-50">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-gray-500 text-sm">
                    Current month
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Last 7 Days</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $attendances->where('scanned_at', '>=', now()->subDays(7))->count() }}
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-pink-50">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-gray-500 text-sm">
                    Recent activity
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Attendance Rate</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">96%</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-50">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-gray-500 text-sm">
                    Based on expected
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter and Search Section -->
    <div class="mb-6 bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Attendance History</h2>
                <p class="text-gray-600 text-sm mt-1">Detailed view of your attendance records</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:flex-initial">
                    <input type="text" placeholder="Search records..." class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div class="flex gap-2">
                    <select class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all duration-200 bg-white">
                        <option>All Time</option>
                        <option>This Month</option>
                        <option>Last 7 Days</option>
                        <option>Today</option>
                    </select>
                    <button class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Attendance Table -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gradient-to-r from-blue-50 to-purple-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <span>Date & Time</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Session Token
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            QR Data
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($attendances as $attendance)
                    <tr class="hover:bg-blue-50/50 transition-colors duration-150 group">
                        <td class="px-6 py-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-100 to-purple-100 flex flex-col items-center justify-center">
                                        <span class="text-lg font-bold text-blue-600">{{ $attendance->scanned_at->format('d') }}</span>
                                        <span class="text-xs text-purple-600">{{ $attendance->scanned_at->format('M') }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $attendance->scanned_at->format('l, F d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $attendance->scanned_at->format('h:i A') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="inline-flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                <span class="px-3 py-1.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-lg">
                                    {{ Str::limit($attendance->attendance_token, 12) }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Unique session ID</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center">
                                <div class="relative">
                                    <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500 absolute top-0 left-0 animate-ping"></div>
                                </div>
                                <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-green-100 to-emerald-100 text-green-800">
                                    Present
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Successfully recorded</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="group relative">
                                <div class="text-sm text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded-lg truncate max-w-xs border border-gray-200">
                                    {{ Str::limit($attendance->qr_code_data, 30) }}
                                </div>
                                <div class="absolute invisible group-hover:visible z-10 w-64 p-3 mt-1 bg-gray-900 text-white text-xs rounded-lg shadow-lg">
                                    <div class="font-mono break-words">{{ $attendance->qr_code_data }}</div>
                                    <div class="absolute -top-1 left-4 w-2 h-2 bg-gray-900 transform rotate-45"></div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Encrypted QR data</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button class="p-2 hover:bg-blue-100 rounded-lg transition-colors duration-150" title="View Details">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-purple-100 rounded-lg transition-colors duration-150" title="Copy Token">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No attendance records yet</h3>
                                <p class="text-gray-500 mb-4">Your attendance records will appear here</p>
                                <div class="text-sm text-gray-500">
                                    Scan a QR code to mark your attendance
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Table Footer -->
        @if($attendances->count() > 0)
        <div class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ $attendances->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $attendances->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $attendances->total() }}</span> records
            </div>
            <div class="flex items-center gap-2">
                @if($attendances->currentPage() > 1)
                <a href="{{ $attendances->previousPageUrl() }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                </a>
                @endif
                
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= min(5, $attendances->lastPage()); $i++)
                        @if($i == $attendances->currentPage())
                        <span class="px-3 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg text-sm">
                            {{ $i }}
                        </span>
                        @else
                        <a href="{{ $attendances->url($i) }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors duration-200">
                            {{ $i }}
                        </a>
                        @endif
                    @endfor
                    
                    @if($attendances->lastPage() > 5)
                    <span class="px-3 py-2 text-gray-500">...</span>
                    <a href="{{ $attendances->url($attendances->lastPage()) }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors duration-200">
                        {{ $attendances->lastPage() }}
                    </a>
                    @endif
                </div>
                
                @if($attendances->hasMorePages())
                <a href="{{ $attendances->nextPageUrl() }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors duration-200 flex items-center gap-1">
                    Next
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>
    
    <!-- Summary Cards -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Most Active Day</p>
                    <p class="text-2xl font-bold mt-2">
                        @php
                            $mostActiveDay = $attendances->groupBy(function($item) {
                                return $item->scanned_at->format('l');
                            })->sortByDesc(function($group) {
                                return $group->count();
                            })->keys()->first();
                        @endphp
                        {{ $mostActiveDay ?? 'N/A' }}
                    </p>
                    <p class="text-blue-100 text-sm mt-1">Based on attendance frequency</p>
                </div>
                <div class="p-3 rounded-full bg-white/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-pink-500 to-purple-500 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 text-sm font-medium">Last Attendance</p>
                    <p class="text-2xl font-bold mt-2">
                        {{ $attendances->last() ? $attendances->last()->scanned_at->format('M d') : 'N/A' }}
                    </p>
                    <p class="text-pink-100 text-sm mt-1">
                        {{ $attendances->last() ? $attendances->last()->scanned_at->format('h:i A') : 'N/A' }}
                    </p>
                </div>
                <div class="p-3 rounded-full bg-white/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-blue-500 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Consistency Score</p>
                    <p class="text-2xl font-bold mt-2">96%</p>
                    <p class="text-green-100 text-sm mt-1">Excellent attendance rate</p>
                </div>
                <div class="p-3 rounded-full bg-white/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Help Text -->
    <div class="mt-8 bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-2xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">About Attendance Records</h3>
                <p class="text-gray-600 mt-2">
                    Your attendance is automatically recorded when you scan QR codes during lectures. 
                    Each record includes a unique session token and timestamp for verification.
                </p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-white text-blue-700 rounded-full text-sm font-medium border border-blue-200">
                        Real-time tracking
                    </span>
                    <span class="px-3 py-1 bg-white text-purple-700 rounded-full text-sm font-medium border border-purple-200">
                        Encrypted data
                    </span>
                    <span class="px-3 py-1 bg-white text-green-700 rounded-full text-sm font-medium border border-green-200">
                        Verified attendance
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth scrolling and selection */
    * {
        scroll-behavior: smooth;
    }
    
    ::selection {
        background-color: rgba(99, 102, 241, 0.2);
        color: #1f2937;
    }
    
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #3b82f6, #8b5cf6);
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to right, #2563eb, #7c3aed);
    }
    
    /* Table row hover effects */
    tr {
        position: relative;
        transition: all 0.2s ease;
    }
    
    /* Status indicator animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-ping {
        animation: pulse 2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
    
    /* Gradient text for headers */
    .gradient-text {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Card hover effects */
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    /* Pagination active state */
    .pagination-active {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        color: white;
        border: none;
    }
</style>

@endsection