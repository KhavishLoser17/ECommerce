@extends('layouts.admin')
@section('content')
<div class="flex flex-col flex-1 overflow-hidden">
    <!-- Top navbar -->
    <div class="flex items-center justify-between h-16 bg-white border-b border-gray-200 px-4 md:px-6">
        <div class="flex items-center">
            <button class="text-gray-500 focus:outline-none md:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-5xl font-semibold text-gray-800 ml-4">Faculty Management</h1>
        </div>

    </div>

    <!-- Content area -->
    <div class="flex-1 overflow-auto p-4 md:p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-semibold text-gray-800">Faculty Members</h2>
                <p class="text-3xl text-gray-600">Manage all your teaching staff</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <select class="appearance-none pl-3 pr-10 py-2 text-2xl bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>All Departments</option>
                        <option>Computer Science</option>
                        <option>Mathematics</option>
                        <option>Physics</option>
                        <option>Languages</option>
                        <option>History</option>
                    </select>
                    <div class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <button id="open-modal-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-2xl font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>Add Teacher
                </button>
            </div>
        </div>

        <!-- Filter and sort options -->
        <div class="flex flex-col md:flex-row justify-between mb-6 bg-white p-4 rounded-lg shadow-sm">
            <div class="flex flex-wrap items-center gap-3 mb-3 md:mb-0">
                <span class="text-2xl font-medium text-gray-700">Filter by:</span>
                <button class="px-3 py-1 text-2xl border rounded-full text-gray-700 hover:bg-gray-100">
                    Full-Time
                </button>
                <button class="px-3 py-1 text-2xl border rounded-full text-gray-700 hover:bg-gray-100">
                    Part-Time
                </button>
                <button class="px-3 py-1 text-2xl border rounded-full text-gray-700 hover:bg-gray-100">
                    On Leave
                </button>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-2xl font-medium text-gray-700">Sort by:</span>
                <select class="appearance-none pl-3 pr-10 py-1 text-2xl bg-white border rounded-lg focus:outline-none">
                    <option>Name</option>
                    <option>Department</option>
                    <option>Experience</option>
                    <option>Status</option>
                    <option>Date Added</option>
                </select>
            </div>
        </div>

        <!-- Faculty list -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Working Hours
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Teacher
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Classes
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($teachers as $teacher)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                                {{ \Carbon\Carbon::parse($teacher->working_hours_start)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($teacher->working_hours_end)->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <a href="{{ asset('storage/' . $teacher->profile_image) }}" target="_blank">
                                            <img class="h-10 w-10 rounded-full hover:scale-110 transition-transform duration-200"
                                                 src="{{ $teacher->profile_image ? asset('storage/' . $teacher->profile_image) : asset('api/placeholder/40/40') }}"
                                                 alt="{{ $teacher->first_name }}">
                                        </a>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-2xl font-medium text-gray-900">
                                            {{ $teacher->title }} {{ $teacher->first_name }} {{ $teacher->last_name }}
                                        </div>
                                        <div class="text-2xl text-gray-500">
                                            Facilitator
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-2xl text-gray-900">{{ $teacher->course }}</div>
                                <div class="text-2xl text-gray-500">Faculty</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-2xl leading-5 font-semibold rounded-full
                                    {{ $teacher->status == 'Full-Time' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $teacher->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                                <div>{{ $teacher->email }}</div>
                                <div>{{ $teacher->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                                {{ $teacher->classes }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-2xl font-medium">
                                <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-teacher-btn" data-teacher-id="{{ $teacher->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="text-red-600 hover:text-red-900" onclick="deleteTeacher({{ $teacher->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between bg-white px-4 py-3 mt-4 rounded-lg shadow-sm">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-2xl font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-2xl font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-2xl text-gray-700">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">24</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-2xl font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                        <a href="#" aria-current="page" class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-2xl font-lg">
                            1
                        </a>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-2xl font-lg">
                            2
                        </a>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-2xl font-medium">
                            3
                        </a>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-2xl font-medium text-gray-700">
                            ...
                        </span>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-2xl font-medium">
                            5
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-2xl font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="teacher-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add Teacher</h2>

        <form id="add-teacher-form" action="{{route('teachers.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Personal Information Section -->
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xl font-medium text-gray-700 mb-2" for="first-name">First Name*</label>
                        <input type="text" id="first-name" name="first_name" required class="w-full px-4 py-3 text-xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xl font-medium text-gray-700 mb-2" for="last-name">Last Name*</label>
                        <input type="text" id="last-name" name="last_name" required class="w-full px-4 py-3 text-xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xl font-medium text-gray-700 mb-2" for="title">Title</label>
                        <select id="title" name="title" class="w-full px-4 py-3 text-xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Title</option>
                            <option value="Prof.">Prof.</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Engr.">Engr.</option>
                            <option value="Instructor">Instructor</option>
                            <option value="Asst. Prof.">Asst. Prof.</option>
                            <option value="Assoc. Prof.">Assoc. Prof.</option>
                            <option value="Dean">Dean</option>
                            <option value="Chairperson">Chairperson</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Schedule & Contact Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="working-hours-start">
                            Working Hours (Start)*
                        </label>
                        <input type="time" id="working-hours-start" name="working_hours_start" required value="09:00"
                            class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="working-hours-end">
                            Working Hours (End)*
                        </label>
                        <input type="time" id="working-hours-end" name="working_hours_end" required value="17:00"
                            class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="email">
                            Email Address*
                        </label>
                        <input type="email" id="email" name="email" required placeholder="name@school.edu"
                            class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="phone">
                            Phone Number
                        </label>
                        <input type="tel" id="phone" name="phone" placeholder="(555) 123-4567"
                            class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
            <!-- Department Section -->
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Course Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <select id="course" name="course" required class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Course</option>
                            <option value="BS Information Technology">BS Information Technology</option>
                            <option value="BS Computer Science">BS Computer Science</option>
                            <option value="BS Business Administration">BS Business Administration</option>
                            <option value="BS Hospitality Management">BS Hospitality Management</option>
                            <option value="BS Tourism Management">BS Tourism Management</option>
                            <option value="BS Criminology">BS Criminology</option>
                            <option value="BS Accountancy">BS Accountancy</option>
                            <option value="BS Psychology">BS Psychology</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-2xl font-medium text-gray-700 mb-2" for="classes">
                    Number of Classes
                </label>
                <input type="number" id="classes" name="classes" min="0" max="10" value="0"
                    class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Profile Image</h3>
                <div class="flex items-center">
                    <div class="mr-4">
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                            <img id="profile-preview" src="/api/placeholder/96/96" alt="Profile preview" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="profile-image">
                            Upload Image
                        </label>
                        <input type="file" id="profile-image" name="profile_image" accept="image/*"
                            class="w-full text-2xl text-gray-700">
                        <p class="mt-1 text-xl text-gray-500">JPG, PNG or GIF up to 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Form Action Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <button type="button" id="cancel-btn" onclick="closeModal()"
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg text-xl font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg text-xl font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>Add Teacher
                </button>
            </div>
        </form>
    </div>
</div>

<div id="edit-teacher-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Teacher</h2>
        <form id="edit-teacher-form" action="{{ route('teachers.update', ['teacher' => $teacher->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Personal Information Section -->
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xl font-medium text-gray-700 mb-2" for="first-name">First Name*</label>
                        <input type="text" id="edit-first-name" name="first_name" value="{{ old('first_name', $teacher->first_name) }}" required class="w-full px-4 py-3 text-xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xl font-medium text-gray-700 mb-2" for="last-name">Last Name*</label>
                        <input type="text" id="edit-last-name" name="last_name" value="{{ old('last_name', $teacher->last_name) }}" required class="w-full px-4 py-3 text-xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xl font-medium text-gray-700 mb-2" for="title">Title</label>
                        <select id="title" name="title" class="w-full px-4 py-3 text-xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Title</option>
                            <option value="Prof." {{ old('title', $teacher->title) == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                            <option value="Dr." {{ old('title', $teacher->title) == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                            <option value="Engr." {{ old('title', $teacher->title) == 'Engr.' ? 'selected' : '' }}>Engr.</option>
                            <option value="Instructor" {{ old('title', $teacher->title) == 'Instructor' ? 'selected' : '' }}>Instructor</option>
                            <option value="Asst. Prof." {{ old('title', $teacher->title) == 'Asst. Prof.' ? 'selected' : '' }}>Asst. Prof.</option>
                            <option value="Assoc. Prof." {{ old('title', $teacher->title) == 'Assoc. Prof.' ? 'selected' : '' }}>Assoc. Prof.</option>
                            <option value="Dean" {{ old('title', $teacher->title) == 'Dean' ? 'selected' : '' }}>Dean</option>
                            <option value="Chairperson" {{ old('title', $teacher->title) == 'Chairperson' ? 'selected' : '' }}>Chairperson</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" id="teacher-id" name="teacher_id">

            <!-- Schedule & Contact Information Section -->
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Schedule & Contact Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="working-hours-start">Working Hours (Start)*</label>
                        <input type="time" id="edit-working-hours-start" name="working_hours_start" value="{{ old('working_hours_start', $teacher->working_hours_start) }}" required class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="working-hours-end">Working Hours (End)*</label>
                        <input type="time" id="edit-working-hours-end" name="working_hours_end" value="{{ old('working_hours_end', $teacher->working_hours_end) }}" required class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="email">Email Address*</label>
                        <input type="email" id="edit-email" name="email" value="{{ old('email', $teacher->email) }}" required class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="phone">Phone Number</label>
                        <input type="tel" id="edit-phone" name="phone" value="{{ old('phone', $teacher->phone) }}" class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Course Information Section -->
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Course Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <select id="course" name="course" required class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Course</option>
                            <option value="BS Information Technology" {{ old('course', $teacher->course) == 'BS Information Technology' ? 'selected' : '' }}>BS Information Technology</option>
                            <option value="BS Computer Science" {{ old('course', $teacher->course) == 'BS Computer Science' ? 'selected' : '' }}>BS Computer Science</option>
                            <option value="BS Business Administration" {{ old('course', $teacher->course) == 'BS Business Administration' ? 'selected' : '' }}>BS Business Administration</option>
                            <option value="BS Hospitality Management" {{ old('course', $teacher->course) == 'BS Hospitality Management' ? 'selected' : '' }}>BS Hospitality Management</option>
                            <option value="BS Tourism Management" {{ old('course', $teacher->course) == 'BS Tourism Management' ? 'selected' : '' }}>BS Tourism Management</option>
                            <option value="BS Criminology" {{ old('course', $teacher->course) == 'BS Criminology' ? 'selected' : '' }}>BS Criminology</option>
                            <option value="BS Accountancy" {{ old('course', $teacher->course) == 'BS Accountancy' ? 'selected' : '' }}>BS Accountancy</option>
                            <option value="BS Psychology" {{ old('course', $teacher->course) == 'BS Psychology' ? 'selected' : '' }}>BS Psychology</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-2xl font-medium text-gray-700 mb-2" for="classes">Number of Classes</label>
                <input type="number" id="edit-classes" name="classes" min="0" max="10" value="{{ old('classes', $teacher->classes) }}" class="w-full px-4 py-3 text-2xl border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Profile Image Section -->
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Profile Image</h3>
                <div class="flex items-center">
                    <div class="mr-4">
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                            <img id="edit-profile-preview" src="{{ asset('storage/' . $teacher->profile_image) }}" alt="Profile preview" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div>
                        <label class="block text-2xl font-medium text-gray-700 mb-2" for="profile-image">Upload Image</label>
                        <input type="file" id="edit-profile-image" name="profile_image" accept="image/*" class="w-full text-2xl text-gray-700">
                        <p class="mt-1 text-xl text-gray-500">JPG, PNG or GIF up to 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Form Action Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <button type="button" id="cancel-btn" onclick="closeModal()"
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg text-xl font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg text-xl font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    // Function to open the modal
    function openModal() {
        document.getElementById('teacher-modal').classList.remove('hidden');
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('teacher-modal').classList.add('hidden');
    }

    // Open modal when clicking the "Add Teacher" button
    document.getElementById('open-modal-btn').addEventListener('click', openModal);

    // Close modal when clicking outside of it
    document.getElementById('teacher-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
<script>
    $(document).ready(function () {
    // Preview image before upload for add form
    $("#profile-image").change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#profile-preview").attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Preview image before upload for edit form
    $("#edit-profile-image").change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#edit-profile-preview").attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // AJAX form submission for add teacher
    $("#add-teacher-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "Teacher Added!",
                    text: "The teacher has been successfully stored.",
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr) {
                let errorMessage = "Something went wrong. Please try again.";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join("\n");
                }

                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: errorMessage,
                });
            }
        });
    });

    // AJAX form submission for edit teacher
    $("#edit-teacher-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Using POST because we include _method field for PUT
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "Teacher Updated!",
                    text: "The teacher has been successfully updated.",
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr) {
                let errorMessage = "Something went wrong. Please try again.";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join("\n");
                }

                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: errorMessage,
                });
            }
        });
    });
});

// Edit teacher button click
document.querySelectorAll('.edit-teacher-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const teacherId = this.getAttribute('data-teacher-id');

        // Set the form action URL with the correct teacher ID
        document.getElementById('edit-teacher-form').action = `/teachers/${teacherId}`;

        // Set the hidden input field value
        document.getElementById('teacher-id').value = teacherId;

        // Fetch the teacher data using AJAX
        fetch(`/teachers/${teacherId}/edit`)
            .then(response => response.json())
            .then(data => {
                const teacher = data.teacher;

                // Open the EDIT modal, not the add modal
                document.getElementById('edit-teacher-modal').classList.remove('hidden');

                // Populate form fields with proper IDs in the edit form
                document.getElementById('first-name').value = teacher.first_name;
                document.getElementById('last-name').value = teacher.last_name;
                document.getElementById('email').value = teacher.email;
                document.getElementById('phone').value = teacher.phone;
                document.getElementById('working-hours-start').value = teacher.working_hours_start;
                document.getElementById('working-hours-end').value = teacher.working_hours_end;
                document.getElementById('course').value = teacher.course;
                document.getElementById('classes').value = teacher.classes;

                // Set profile image preview
                document.getElementById('profile-preview').src = `/storage/${teacher.profile_image}`;

                // Set title dropdown
                const titleSelect = document.getElementById('title');
                for (let i = 0; i < titleSelect.options.length; i++) {
                    if (titleSelect.options[i].value === teacher.title) {
                        titleSelect.selectedIndex = i;
                        break;
                    }
                }
            });
    });
});

// Functions to show/hide modals
function openAddModal() {
    document.getElementById('teacher-modal').classList.remove('hidden');
}

function openEditModal() {
    document.getElementById('edit-teacher-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('teacher-modal').classList.add('hidden');
    document.getElementById('edit-teacher-modal').classList.add('hidden');
}
</script>
<script>
    function deleteTeacher(teacherId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/teacher/${teacherId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Deleted!", data.message, "success").then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error!", data.message, "error");
                    }
                })
                .catch(error => {
                    Swal.fire("Error!", "Something went wrong.", "error");
                });
            }
        });
    }
</script>

@endsection
