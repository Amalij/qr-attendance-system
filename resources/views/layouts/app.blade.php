<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'QR Attendance System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <head>
    <!-- Your existing head content -->
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-qrcode text-2xl"></i>
                    <span class="text-xl font-bold">QR Attendance</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                    <span>Welcome, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        @auth
        <aside class="w-64 bg-white shadow-lg min-h-screen">
            <nav class="mt-6">
                @if(auth()->user()->isAdmin())
                <!-- Admin Sidebar -->
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.students') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('admin.students*') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Students</span>
                    </a>
                    <a href="{{ route('admin.lecturers') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('admin.lecturers*') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Lecturers</span>
                    </a>
                    <a href="{{ route('admin.courses') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('admin.courses*') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Courses</span>
                    </a>
                    <a href="{{ route('admin.reports.attendance') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('admin.reports*') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </div>
                @elseif(auth()->user()->isLecturer())
                <!-- Lecturer Sidebar -->
                <div class="px-4 space-y-2">
                    <a href="{{ route('lecturer.dashboard') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('lecturer.dashboard') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('lecturer.courses') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('lecturer.courses') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="{{ route('lecturer.reports.attendance') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('lecturer.reports*') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Attendance Reports</span>
                    </a>
                </div>
                @else
                <!-- Student Sidebar -->
                <div class="px-4 space-y-2">
                    <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('student.dashboard') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <!-- <a href="{{ route('student.courses') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('student.courses') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a> -->
                    <a href="{{ route('student.attendance') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('student.attendance') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Attendance History</span>
                    </a>
                    <a href="{{ route('student.scan') }}" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded {{ request()->routeIs('student.scan') ? 'bg-blue-100 text-blue-600' : '' }}">
                        <i class="fas fa-qrcode"></i>
                        <span>Scan QR Code</span>
                    </a>
                </div>
                @endif
            </nav>
        </aside>
        @endauth

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>