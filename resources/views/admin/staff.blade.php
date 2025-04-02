@extends('layouts.admin')
@section('content')
<div class="flex flex-col flex-1 overflow-hidden">
    <!-- Top navbar -->
    <div class="flex items-center justify-between h-16 bg-white border-b border-gray-200 px-4 md:px-6">

    </div>

    <!-- Content area -->
    <div class="flex-1 overflow-auto p-4 md:p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-5xl font-semibold text-gray-800">Staff Members</h2>
                <p class="text-2xl text-gray-600">Manage all your administrative and support staff</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <select class="appearance-none pl-3 pr-10 py-2 text-2xl bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>All Departments</option>
                        <option>Administration</option>
                        <option>Finance</option>
                        <option>IT Support</option>
                        <option>Library</option>
                        <option>Maintenance</option>
                        <option>Security</option>
                    </select>
                    <div class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <button id="openModalBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-2xl font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>Add Staff
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
                    Active
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
        <!-- Staff list -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Working Hours
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Staff Member
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
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-2xl font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($staffs as $staff)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                            {{ $staff->working_hours ?? 'N/A' }}
                        </td>
                        <!-- Example in table row -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($staff->profile_picture)
                                        <a href="{{ asset('storage/' . $staff->profile_picture) }}" target="_blank">
                                            <img class="h-10 w-10 rounded-full hover:scale-110 transition-transform duration-200 object-cover"
                                                src="{{ asset('storage/' . $staff->profile_picture) }}"
                                                alt="{{ $staff->name }}">
                                        </a>
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 text-sm">{{ substr($staff->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-4">
                                    <div class="text-2xl font-medium text-gray-900">{{ $staff->name }}</div>
                                    <div class="text-2xl text-gray-500">{{ $staff->title }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-2xl text-gray-900">{{ $staff->department }}</div>
                            <div class="text-2xl text-gray-900">Faculty</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'Full-Time' => 'bg-green-100 text-green-800',
                                    'Part-Time' => 'bg-blue-100 text-blue-800',
                                    'Contractor' => 'bg-yellow-100 text-yellow-800'
                                ];
                                $statusClass = $statusClasses[$staff->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-2xl leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $staff->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                            <div>{{ $staff->email }}</div>
                            <div>{{ $staff->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                            {{ $staff->role }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-2xl font-medium">
                            <button onclick="openEditModal({{ $staff->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($staffs->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-2xl text-gray-500">No staff members found.</p>
            </div>
            @endif
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
                        Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">18</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-2xl font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left text-2xl"></i>
                        </a>
                        <a href="#" aria-current="page" class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-2xl font-medium">
                            1
                        </a>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-2xl font-medium">
                            2
                        </a>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-2xl font-medium">
                            3
                        </a>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-2xl font-medium">
                            4
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-2xl font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right text-2xl"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="staffmodal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl w-full mx-4">
        <div class="bg-blue-600 px-6 py-4 flex justify-between items-center rounded-t-lg">
            <h3 class="text-2xl font-medium text-white">Add New Staff Member</h3>
            <button id="closeModalBtn" class="text-white hover:text-gray-200 focus:outline-none">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <div class="p-6">
            <form id="addStaffForm" action="{{ route('staff.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="staffName" class="block text-xl font-medium text-gray-700">Staff Name</label>
                            <input type="text" id="staffName" name="name" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                        </div>

                        <div>
                            <label for="staffTitle" class="block text-xl font-medium text-gray-700">Title/Position</label>
                            <select id="staffTitle" name="title" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                                <option value="">Select Position</option>
                                <option value="Dean">Dean</option>
                                <option value="Department Chair">Department Chair</option>
                                <option value="Program Coordinator">Program Coordinator</option>
                                <option value="Registrar">Registrar</option>
                                <option value="Guidance Counselor">Guidance Counselor</option>
                                <option value="Librarian">Librarian</option>
                                <option value="Administrative Staff">Administrative Staff</option>
                            </select>
                        </div>

                        <div>
                            <label for="staffEmail" class="block text-xl font-medium text-gray-700">Email</label>
                            <input type="email" id="staffEmail" name="email" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                        </div>

                        <div>
                            <label for="staffPhone" class="block text-xl font-medium text-gray-700">Phone</label>
                            <input type="tel" id="staffPhone" name="phone" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                        </div>
                    </div>

                    <!-- Work Details -->
                    <div class="space-y-4">
                        <div>
                            <label for="workingHours" class="block text-xl font-medium text-gray-700">Working Hours</label>
                            <select id="workingHours" name="working_hours" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                                <option value="">Select Working Hours</option>
                                <option value="7:00 AM - 4:00 PM">7:00 AM - 4:00 PM</option>
                                <option value="8:00 AM - 5:00 PM">8:00 AM - 5:00 PM</option>
                                <option value="9:00 AM - 6:00 PM">9:00 AM - 6:00 PM</option>
                                <option value="Flexible Hours">Flexible Hours</option>
                                <option value="Part-Time Morning">Part-Time Morning</option>
                                <option value="Part-Time Afternoon">Part-Time Afternoon</option>
                                <option value="Part-Time Evening">Part-Time Evening</option>
                            </select>
                        </div>

                        <div>
                            <label for="department" class="block text-xl font-medium text-gray-700">Department</label>
                            <select id="department" name="department" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                                <option value="">Select Department</option>
                                <option value="College of Accountancy">College of Accountancy</option>
                                <option value="College of Business Administration">College of Business Administration</option>
                                <option value="College of Computer Studies">College of Computer Studies</option>
                                <option value="College of Education">College of Education</option>
                                <option value="College of Engineering">College of Computer Engineering</option>
                                <option value="College of Hospitality Management">College of Hospitality Management</option>
                                <option value="College of Nursing">College of Psychology</option>
                                <option value="Senior High School">Senior High School</option>
                                <option value="Administration">Administration</option>
                                <option value="Finance">Finance</option>
                                <option value="Human Resources">Human Resources</option>
                                <option value="Registrar's Office">Registrar's Office</option>
                                <option value="Library">Library</option>
                                <option value="Guidance Office">Guidance Office</option>
                                <option value="Research and Development">Research and Development</option>
                            </select>
                        </div>
                        <div>
                            <label for="role" class="block text-xl font-medium text-gray-700">Role</label>
                            <select id="role" name="role" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                                <option value="">Select Role</option>
                                <option value="Faculty Member">Faculty Member</option>
                                <option value="Department Head">Department Head</option>
                                <option value="Academic Coordinator">Academic Coordinator</option>
                                <option value="Research Coordinator">Research Coordinator</option>
                                <option value="Extension Coordinator">Extension Coordinator</option>
                                <option value="Student Affairs Officer">Student Affairs Officer</option>
                                <option value="Administrative Officer">Administrative Officer</option>
                                <option value="Finance Officer">Finance Officer</option>
                                <option value="HR Officer">HR Officer</option>
                                <option value="Registrar Staff">Registrar Staff</option>
                                <option value="Librarian">Librarian</option>
                                <option value="Guidance Counselor">Guidance Counselor</option>
                                <option value="IT Support">IT Support</option>
                                <option value="Maintenance Staff">Maintenance Staff</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xl font-medium text-gray-700">Status</label>
                    <div class="mt-2 flex items-center space-x-6">
                        <div class="flex items-center">
                            <input id="status-full-time" name="status" type="radio" value="Full-Time" class="h-5 w-5 text-blue-600 border-gray-300" checked>
                            <label for="status-full-time" class="ml-2 block text-xl text-gray-700">Full-Time</label>
                        </div>
                        <div class="flex items-center">
                            <input id="status-part-time" name="status" type="radio" value="Part-Time" class="h-5 w-5 text-blue-600 border-gray-300">
                            <label for="status-part-time" class="ml-2 block text-xl text-gray-700">Part-Time</label>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xl font-medium text-gray-700">Profile Picture</label>
                    <div class="mt-2 flex items-center">
                        <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-full overflow-hidden">
                            <img id="profilePreview" class="h-full w-full object-cover" src="" alt="Profile preview">
                        </div>
                        <button type="button" id="uploadBtn" class="ml-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-xl font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Upload Image
                        </button>
                        <input type="file" id="profilePicture" name="profile_picture" accept="image/*" class="hidden">
                    </div>
                </div>
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" id="cancelBtn" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg text-xl font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg text-xl font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Save Staff Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editStaffModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl w-full mx-4">
        <div class="bg-blue-600 px-6 py-4 flex justify-between items-center rounded-t-lg">
            <h3 class="text-2xl font-medium text-white">Edit Staff Member</h3>
            <button id="closeEditModalBtn" class="text-white hover:text-gray-200 focus:outline-none">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="editStaffForm" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editStaffId" name="id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="editStaffName" class="block text-xl font-medium text-gray-700">Staff Name</label>
                            <input type="text" id="editStaffName" name="name" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                        </div>

                        <div>
                            <label for="staffTitle" class="block text-xl font-medium text-gray-700">Title/Position</label>
                            <select id="editStaffTitle" name="title" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                                <option value="">Select Position</option>
                                <option value="Dean">Dean</option>
                                <option value="Department Chair">Department Chair</option>
                                <option value="Program Coordinator">Program Coordinator</option>
                                <option value="Registrar">Registrar</option>
                                <option value="Guidance Counselor">Guidance Counselor</option>
                                <option value="Librarian">Librarian</option>
                                <option value="Administrative Staff">Administrative Staff</option>
                            </select>
                        </div>
                        <div>
                            <label for="staffEmail" class="block text-xl font-medium text-gray-700">Email</label>
                            <input type="email" id="editStaffEmail" name="email" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                        </div>

                        <div>
                            <label for="staffPhone" class="block text-xl font-medium text-gray-700">Phone</label>
                            <input type="tel" id="editStaffPhone" name="phone" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                        </div>
                    </div>

                    <!-- Work Details -->
                    <div class="space-y-4">
                        <div>
                            <label for="workingHours" class="block text-xl font-medium text-gray-700">Working Hours</label>
                            <select id="editWorkingHours" name="working_hours" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                                <option value="">Select Working Hours</option>
                                <option value="7:00 AM - 4:00 PM">7:00 AM - 4:00 PM</option>
                                <option value="8:00 AM - 5:00 PM">8:00 AM - 5:00 PM</option>
                                <option value="9:00 AM - 6:00 PM">9:00 AM - 6:00 PM</option>
                                <option value="Flexible Hours">Flexible Hours</option>
                                <option value="Part-Time Morning">Part-Time Morning</option>
                                <option value="Part-Time Afternoon">Part-Time Afternoon</option>
                                <option value="Part-Time Evening">Part-Time Evening</option>
                            </select>
                        </div>

                        <div>
                            <label for="department" class="block text-xl font-medium text-gray-700">Department</label>
                            <select id="editDepartment" name="department" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                                <option value="">Select Department</option>
                                <option value="College of Accountancy">College of Accountancy</option>
                                <option value="College of Business Administration">College of Business Administration</option>
                                <option value="College of Computer Studies">College of Computer Studies</option>
                                <option value="College of Education">College of Education</option>
                                <option value="College of Engineering">College of Computer Engineering</option>
                                <option value="College of Hospitality Management">College of Hospitality Management</option>
                                <option value="College of Nursing">College of Psychology</option>
                                <option value="Senior High School">Senior High School</option>
                                <option value="Administration">Administration</option>
                                <option value="Finance">Finance</option>
                                <option value="Human Resources">Human Resources</option>
                                <option value="Registrar's Office">Registrar's Office</option>
                                <option value="Library">Library</option>
                                <option value="Guidance Office">Guidance Office</option>
                                <option value="Research and Development">Research and Development</option>
                            </select>
                        </div>
                        <div>
                            <label for="role" class="block text-xl font-medium text-gray-700">Role</label>
                            <select id="editRole" name="role" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm text-xl">
                                <option value="">Select Role</option>
                                <option value="Faculty Member">Faculty Member</option>
                                <option value="Department Head">Department Head</option>
                                <option value="Academic Coordinator">Academic Coordinator</option>
                                <option value="Research Coordinator">Research Coordinator</option>
                                <option value="Extension Coordinator">Extension Coordinator</option>
                                <option value="Student Affairs Officer">Student Affairs Officer</option>
                                <option value="Administrative Officer">Administrative Officer</option>
                                <option value="Finance Officer">Finance Officer</option>
                                <option value="HR Officer">HR Officer</option>
                                <option value="Registrar Staff">Registrar Staff</option>
                                <option value="Librarian">Librarian</option>
                                <option value="Guidance Counselor">Guidance Counselor</option>
                                <option value="IT Support">IT Support</option>
                                <option value="Maintenance Staff">Maintenance Staff</option>
                            </select>
                        </div>
                    </div>
                <!-- Status -->
                <div>
                    <label class="block text-xl font-medium text-gray-700">Status</label>
                    <div class="mt-2 flex items-center space-x-6">
                        <div class="flex items-center">
                            <input id="editStatus-full-time" name="status" type="radio" value="Full-Time" class="h-5 w-5 text-blue-600 border-gray-300">
                            <label for="editStatus-full-time" class="ml-2 block text-xl text-gray-700">Full-Time</label>
                        </div>
                        <div class="flex items-center">
                            <input id="editStatus-part-time" name="status" type="radio" value="Part-Time" class="h-5 w-5 text-blue-600 border-gray-300">
                            <label for="editStatus-part-time" class="ml-2 block text-xl text-gray-700">Part-Time</label>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xl font-medium text-gray-700">Profile Picture</label>
                    <div class="mt-2 flex items-center">
                        <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-full overflow-hidden">
                            <img id="editProfilePreview" class="h-full w-full object-cover" src="" alt="Profile preview">
                        </div>
                        <button type="button" id="editUploadBtn" class="ml-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-xl font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Upload Image
                        </button>
                        <input type="file" id="editProfilePicture" name="profile_picture" accept="image/*" class="hidden">
                    </div>
                </div>
             </div>
             </div>

                <!-- Profile Picture and buttons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" id="cancelEditBtn" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg text-xl font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg text-xl font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Update Staff Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get modal elements
        const modal = document.getElementById('staffmodal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const uploadBtn = document.getElementById('uploadBtn');
        const profilePicture = document.getElementById('profilePicture');
        const profilePreview = document.getElementById('profilePreview');

        // Open modal
        openModalBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        });

        // Close modal
        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Re-enable scrolling
        }

        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Profile picture upload preview
        uploadBtn.addEventListener('click', function() {
            profilePicture.click();
        });

        profilePicture.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    profilePreview.src = event.target.result;
                };

                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Form submission handling
        const form = document.getElementById('addStaffForm');
        if (form) {
            form.addEventListener('submit', function(e) {

            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('addStaffForm');
        const profilePicture = document.getElementById('profilePicture');
        const profilePreview = document.getElementById('profilePreview');
        const uploadBtn = document.getElementById('uploadBtn');

        // Profile picture preview
        uploadBtn.addEventListener('click', () => profilePicture.click());
        profilePicture.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profilePreview.src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            // You can add loading state here if needed
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Saving...';

            // Using Fetch API for AJAX submission
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reset form and close modal if needed
                        form.reset();
                        profilePreview.src = '';
                        document.getElementById('staffmodal').classList.add('hidden');

                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while saving the staff member.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Save Staff Member';
            });
        });
    });
    </script>

    <script>
async function openEditModal(staffId) {
    try {
        const editModal = document.getElementById('editStaffModal');
        if (!editModal) {
            console.error('Edit modal not found');
            return;
        }

        editModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Show loading state
        const submitBtn = document.querySelector('#editStaffForm button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Loading...';
        }

        const response = await fetch(`/staff/${staffId}/edit`);
        if (!response.ok) {
            throw new Error('Failed to fetch staff data');
        }

        const staff = await response.json();

        // Helper function to safely set values
        const setValue = (id, value) => {
            const element = document.getElementById(id);
            if (element) element.value = value || '';
        };

        // Populate form fields
        setValue('editStaffId', staff.id);
        setValue('editStaffName', staff.name);
        setValue('editStaffTitle', staff.title);
        setValue('editStaffEmail', staff.email);
        setValue('editStaffPhone', staff.phone);
        setValue('editWorkingHours', staff.working_hours);
        setValue('editDepartment', staff.department);
        setValue('editRole', staff.role);


        // Set radio button
        const statusRadio = document.querySelector(`input[name="status"][value="${staff.status}"]`);
        if (statusRadio) statusRadio.checked = true;

        // Set profile picture preview
        const profilePreview = document.getElementById('editProfilePreview');
        if (profilePreview && staff.profile_picture) {
            profilePreview.src = `/storage/profile_pictures/${staff.profile_picture}`;
        }

        // Set form action
        const form = document.getElementById('editStaffForm');
        if (form) {
            form.action = `/staff/${staffId}`;
        }

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'Failed to load staff data',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    } finally {
        const submitBtn = document.querySelector('#editStaffForm button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Update Staff Member';
        }
    }
}

function closeEditModal() {
    const editModal = document.getElementById('editStaffModal');
    if (editModal) {
        editModal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

// Initialize event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const closeEditModalBtn = document.getElementById('closeEditModalBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const editForm = document.getElementById('editStaffForm');

    if (closeEditModalBtn) {
        closeEditModalBtn.addEventListener('click', closeEditModal);
    }

    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', closeEditModal);
    }

    if (editForm) {
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');

            try {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Updating...';
                }

                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to update staff');
                }

                Swal.fire({
                    title: 'Success!',
                    text: 'Staff member updated successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    closeEditModal();
                    window.location.reload();
                });

            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Update Staff Member';
                }
            }
        });
    }
});
    </script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
});
</script>
@endif
@endsection
