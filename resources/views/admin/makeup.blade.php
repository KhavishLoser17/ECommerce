@extends('layouts.admin')
@section('content')
<main class="flex-grow mx-auto px-4 sm:px-6 lg:px-8 py-8 max-w-full w-full">
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div>
        <h2 class="text-3xl font-bold text-gray-800">Makeup Classes</h2>
        <p class="text-gray-600">Manage scheduled makeup sessions</p>
      </div>

      <div class="flex flex-col sm:flex-row gap-3">
        <button id="openCreateModal" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-2xl font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Create Makeup Class
          </button>
      </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <div class="relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">

            </div>
          </div>
        </div>

        <div class="md:w-48">
          <label for="course-filter" class="block text-2xl font-medium text-gray-700 mb-1">Course</label>
          <select id="course-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-2xl">
            <option value="">All Courses</option>
            <option value="CS101">CS101 - Intro to Programming</option>
            <option value="CS201">CS201 - Data Structures</option>
            <option value="MATH101">MATH101 - Calculus I</option>
            <option value="ENG201">ENG201 - Technical Writing</option>
          </select>
        </div>

        <div class="md:w-48">
          <label for="status-filter" class="block text-2xl font-medium text-gray-700 mb-1">Status</label>
          <select id="status-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-2xl">
            <option value="">All Statuses</option>
            <option value="scheduled">Scheduled</option>
            <option value="in-progress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="canceled">Canceled</option>
          </select>
        </div>

        <div class="md:w-48">
          <label for="date-filter" class="block text-2xl font-medium text-gray-700 mb-1">Date Range</label>
          <select id="date-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-2xl">
            <option value="">All Dates</option>
            <option value="today">Today</option>
            <option value="this-week">This Week</option>
            <option value="this-month">This Month</option>
            <option value="custom">Custom Range</option>
          </select>
        </div>

        <div class="md:w-36 flex items-end">
          <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-2xl font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Apply Filters
          </button>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Class ID
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Title & Course
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Date & Time
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Faculty
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Teacher
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-right text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <!-- Row 1 -->
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                MU-2025-001
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl font-medium text-gray-900">Exam Review Session</div>
                <div class="text-2xl text-gray-500">CS101 - Intro to Programming</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Apr 5, 2025</div>
                <div class="text-2xl text-gray-500">14:00 - 16:00</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                Room 302
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-col">
                  <div class="flex items-center mb-2">
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-1 rounded-full">250 Students</span>
                  </div>
                  <div class="flex items-center">
                    <div class="flex -space-x-2 mr-2">
                      <img src="/api/placeholder/32/32" alt="Teacher" class="h-8 w-8 rounded-full border-2 border-white" />
                      <img src="/api/placeholder/32/32" alt="Teacher" class="h-8 w-8 rounded-full border-2 border-white" />
                      <img src="/api/placeholder/32/32" alt="Teacher" class="h-8 w-8 rounded-full border-2 border-white" />
                    </div>
                    <button class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-1 px-2 rounded-lg flex items-center transition-colors">
                      <span>View All</span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                      </svg>
                    </button>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-2xl leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                  Scheduled
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-2xl font-medium">
                <div class="flex justify-end space-x-2">
                  <button class="text-indigo-600 hover:text-indigo-900" title="View Details">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                      <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                  </button>
                  <button class="text-indigo-600 hover:text-indigo-900" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                  </button>
                  <button class="text-red-600 hover:text-red-900" title="Cancel Class">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>

            <!-- Row 2 -->
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                MU-2025-002
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl font-medium text-gray-900">Additional Lab Session</div>
                <div class="text-2xl text-gray-500">CS201 - Data Structures</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Apr 8, 2025</div>
                <div class="text-2xl text-gray-500">10:00 - 12:30</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-2xl text-gray-500">
                Lab 104
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-semibold">
                    MC
                  </div>
                  <div class="ml-3">
                    <div class="text-2xl font-medium text-gray-900">Prof. Michael Chen</div>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-2xl leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                  Scheduled
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-2xl font-medium">
                <div class="flex justify-end space-x-2">
                  <button class="text-indigo-600 hover:text-indigo-900" title="View Details">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                      <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                  </button>
                  <button class="text-indigo-600 hover:text-indigo-900" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                  </button>
                  <button class="text-red-600 hover:text-red-900" title="Cancel Class">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>

            <div id="createModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl p-6">
                  <!-- Modal Header -->
                  <div class="flex justify-between items-center border-b pb-4">
                    <h2 class="text-2xl font-semibold text-gray-800">Create Makeup Class</h2>
                    <button id="closeCreateModal" class="text-gray-500 hover:text-gray-700">
                      &times;
                    </button>
                  </div>

                  <!-- Modal Content -->
                  <div class="p-4">
                    <form id="makeupClassForm">
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                          <div>
                            <label for="class_title" class="block text-2xl font-medium text-gray-700">Class Title</label>
                            <input type="text" id="class_title" name="class_title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-2xl border-gray-300 rounded-md" placeholder="Enter class title" required>
                          </div>

                          <div>
                            <label for="course_id" class="block text-2xl font-medium text-gray-700">Course</label>
                            <select id="course_id" name="course_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-2xl" required>
                              <option value="" disabled selected>Select course</option>
                              <option value="CS101">CS101 - Introduction to Programming</option>
                              <option value="CS201">CS201 - Data Structures</option>
                              <option value="MATH101">MATH101 - Calculus I</option>
                              <option value="ENG201">ENG201 - Technical Writing</option>
                            </select>
                          </div>

                          <div>
                            <label for="date" class="block text-2xl font-medium text-gray-700">Select Date</label>
                            <input type="date" id="date" name="date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-2xl border-gray-300 rounded-md" required>
                          </div>

                          <div>
                            <label for="time_start" class="block text-2xl font-medium text-gray-700">Start Time</label>
                            <input type="time" id="time_start" name="time_start" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-2xl border-gray-300 rounded-md" required>
                          </div>

                          <div>
                            <label for="time_end" class="block text-2xl font-medium text-gray-700">End Time</label>
                            <input type="time" id="time_end" name="time_end" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-2xl border-gray-300 rounded-md" required>
                          </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                          <div>
                            <label for="faculty" class="block text-2xl font-medium text-gray-700">Faculty</label>
                            <input type="text" id="faculty" name="faculty" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-2xl border-gray-300 rounded-md" placeholder="Enter classroom or virtual link" required>
                          </div>

                          <div>
                            <label for="teacher_id" class="block text-2xl font-medium text-gray-700">Select Teacher</label>
                            <div class="relative">
                              <!-- Dropdown Button -->
                              <button type="button" id="dropdownButton" class="w-full py-2 px-4 border border-gray-300 bg-white rounded-md text-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 flex justify-between items-center">
                                Select Teachers
                                <svg class="ml-2 h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                              </button>

                              <!-- Dropdown Content -->
                              <div id="dropdownMenu" class="absolute w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden z-10">
                                <div class="p-2">
                                  <!-- Select All Option -->
                                  <div class="flex items-center mb-2">
                                    <input type="checkbox" id="select_all" class="form-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-md">
                                    <label for="select_all" class="ml-2 text-lg text-gray-700">Select All Teachers</label>
                                  </div>

                                  <!-- Individual Teacher Checkboxes -->
                                  <div class="space-y-2">
                                    <div class="flex items-center">
                                      <input type="checkbox" id="teacher_1" name="teacher_id[]" value="1" class="form-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-md">
                                      <label for="teacher_1" class="ml-2 text-lg text-gray-700">Dr. Sarah Johnson</label>
                                    </div>
                                    <div class="flex items-center">
                                      <input type="checkbox" id="teacher_2" name="teacher_id[]" value="2" class="form-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-md">
                                      <label for="teacher_2" class="ml-2 text-lg text-gray-700">Prof. Michael Chen</label>
                                    </div>
                                    <div class="flex items-center">
                                      <input type="checkbox" id="teacher_3" name="teacher_id[]" value="3" class="form-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-md">
                                      <label for="teacher_3" class="ml-2 text-lg text-gray-700">Dr. Emily Rodriguez</label>
                                    </div>
                                    <div class="flex items-center">
                                      <input type="checkbox" id="teacher_4" name="teacher_id[]" value="4" class="form-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-md">
                                      <label for="teacher_4" class="ml-2 text-lg text-gray-700">Prof. David Kim</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div>
                            <label for="reason" class="block text-2xl font-medium text-gray-700">Reason for Makeup Class</label>
                            <select id="reason" name="reason" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-2xl" required>
                              <option value="" disabled selected>Select reason</option>
                              <option value="previous_canceled">Previous Class Canceled</option>
                              <option value="holiday">Holiday Recovery</option>
                              <option value="extra_material">Extra Material Coverage</option>
                              <option value="exam_prep">Exam Preparation</option>
                              <option value="other">Other</option>
                            </select>
                          </div>

                          <div>
                            <label for="notes" class="block text-2xl font-medium text-gray-700">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-2xl border-gray-300 rounded-md" placeholder="Enter any additional information"></textarea>
                          </div>
                        </div>
                      </div>

                      <!-- Submit Buttons -->
                      <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="closeCreateModalBtn" class="px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-100 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">Create and Notify</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

        </main>
        <script>
            document.getElementById('openCreateModal').addEventListener('click', function() {
              document.getElementById('createModal').classList.remove('hidden');
            });
            document.getElementById('closeCreateModal').addEventListener('click', function() {
              document.getElementById('createModal').classList.add('hidden');
            });
            document.getElementById('closeCreateModalBtn').addEventListener('click', function() {
              document.getElementById('createModal').classList.add('hidden');
            });
            </script>
            <script>
                const dropdownButton = document.getElementById('dropdownButton');
                const dropdownMenu = document.getElementById('dropdownMenu');
                const selectAllCheckbox = document.getElementById('select_all');
                const teacherCheckboxes = document.querySelectorAll('input[name="teacher_id[]"]');

                // Toggle dropdown visibility
                dropdownButton.addEventListener('click', () => {
                  dropdownMenu.classList.toggle('hidden');
                });

                // Toggle "Select All" checkbox behavior
                selectAllCheckbox.addEventListener('change', () => {
                  teacherCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                  });
                });

                // Update "Select All" checkbox if all individual boxes are checked
                teacherCheckboxes.forEach(checkbox => {
                  checkbox.addEventListener('change', () => {
                    if (![...teacherCheckboxes].some(cb => !cb.checked)) {
                      selectAllCheckbox.checked = true;
                    } else {
                      selectAllCheckbox.checked = false;
                    }
                  });
                });
              </script>

@endsection
