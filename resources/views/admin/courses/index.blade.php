@extends('layouts.app')

@section('title', 'Manage Courses')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Manage Courses</h1>
    <button onclick="document.getElementById('createCourseModal').classList.remove('hidden')" 
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus-circle mr-2"></i>Add Course
    </button>
</div>

<!-- Create Course Modal -->
<div id="createCourseModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Course</h3>
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Course Code</label>
                    <input type="text" name="course_code" required 
                           class="w-full px-3 py-2 border rounded-md" placeholder="e.g., CS101">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Course Name</label>
                    <input type="text" name="course_name" required 
                           class="w-full px-3 py-2 border rounded-md" placeholder="e.g., Introduction to Programming">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Lecturer</label>
                    <select name="lecturer_id" required class="w-full px-3 py-2 border rounded-md">
                        <option value="">Select Lecturer</option>
                        @foreach($lecturers as $lecturer)
                        <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-3 mt-5">
                    <button type="button" onclick="document.getElementById('createCourseModal').classList.add('hidden')"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lecturer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($courses as $course)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $course->course_code }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $course->course_name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $course->lecturer->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $course->students->count() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button onclick="openAssignModal({{ $course->id }})" 
                                class="text-blue-600 hover:text-blue-900 mr-3">
                            Assign Students
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        No courses found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Assign Students Modal -->
<div id="assignModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Assign Students to Course</h3>
            <form id="assignForm" method="POST">
                @csrf
                <div class="mb-4 max-h-60 overflow-y-auto">
                    @foreach(\App\Models\User::students()->get() as $student)
                    <label class="flex items-center space-x-2 mb-2">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" 
                               class="rounded border-gray-300">
                        <span>{{ $student->name }} ({{ $student->email }})</span>
                    </label>
                    @endforeach
                </div>
                <div class="flex justify-end space-x-3 mt-5">
                    <button type="button" onclick="closeAssignModal()"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Assign Students
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
function openAssignModal(courseId) {
    document.getElementById('assignForm').action = `/admin/courses/${courseId}/assign-students`;
    document.getElementById('assignModal').classList.remove('hidden');
}

function closeAssignModal() {
    document.getElementById('assignModal').classList.add('hidden');
}
</script>
@endsection