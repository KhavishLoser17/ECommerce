@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-full w-full">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-2xl font-bold text-gray-800">Announcement Calendar</h1>
      <div class="flex space-x-2">
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Today</button>
        <div class="flex border rounded overflow-hidden">
          <button class="bg-white px-3 py-2 border-r">&lt;</button>
          <span class="bg-white px-4 py-2 font-medium">April 2025</span>
          <button class="bg-white px-3 py-2 border-l">&gt;</button>
        </div>
        <button onclick="openAddScheduleModal()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Add Schedule</button>
      </div>
    </div>
    <div class="p-6 bg-white shadow-md rounded-md h-[50]">
        <div class="grid grid-cols-7 bg-gray-100 font-bold text-center text-2xl">
            <div class="p-2 border border-gray-200">Mon</div>
            <div class="p-2 border border-gray-200">Tue</div>
            <div class="p-2 border border-gray-200">Wed</div>
            <div class="p-2 border border-gray-200">Thu</div>
            <div class="p-2 border border-gray-200">Fri</div>
            <div class="p-2 border border-gray-200">Sat</div>
            <div class="p-2 border border-gray-200">Sun</div>
        </div>

        <div id="calendarGrid" class="grid grid-cols-7 border-t border-l border-gray-200 mb-6">
        </div>
    </div>


    <!-- Legend -->
    <div class="mt-6 flex items-center justify-between">
      <button onclick="openAttendanceReportModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">View Attendance Reports</button>

      <div class="flex space-x-4">
        <div class="flex items-center">
          <div class="w-4 h-4 rounded bg-indigo-100 mr-2"></div>
          <span class="text-2xl text-gray-600">Meetings</span>
        </div>
        <div class="flex items-center">
          <div class="w-4 h-4 rounded bg-green-100 mr-2"></div>
          <span class="text-2xl text-gray-600">Reviews</span>
        </div>
        <div class="flex items-center">
          <div class="w-4 h-4 rounded bg-blue-100 mr-2"></div>
          <span class="text-2xl text-gray-600">Development</span>
        </div>
        <div class="flex items-center">
          <div class="w-4 h-4 rounded bg-red-100 mr-2"></div>
          <span class="text-2xl text-gray-600">Mandatory</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Schedule Modal -->
  <div id="addScheduleModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Create Teacher Schedule</h2>
            <button onclick="closeAddScheduleModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="scheduleForm" action="{{ route('schedules.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Teacher:</label>
                    <select name="teacher_id" class="w-full p-2 border rounded" required>
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                data-working-hours="{{ date('h:i A', strtotime($teacher->working_hours_start)) }} to {{ date('h:i A', strtotime($teacher->working_hours_end)) }}"

                                    data-courses="{{ $teacher->course }}"
                                    data-classes="{{ $teacher->classes }}">
                                {{ $teacher->full_name }}
                            </option>
                        @endforeach
                    </select>
                    <p id="teacherWorkingHours" class="text-xl text-gray-500 mt-1 hidden"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Schedule Type:</label>
                    <select name="schedule_type" class="w-full p-2 border rounded" required>
                        <option value="">Select Schedule Type</option>
                        <option value="class">Class Session</option>
                        <option value="office_hours">Office Hours</option>
                        <option value="meeting">Faculty Meeting</option>
                        <option value="makeup_class">Make-Up Class</option>
                        <option value="event_management">Event Management</option>
                        <option value="other">Other Activity</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Title:</label>
                <input type="text" name="title" class="w-full p-2 border rounded" required placeholder="e.g. Calculus I Lecture">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Description:</label>
                <textarea name="description" class="w-full p-2 border rounded" rows="2" placeholder="Detailed description of the schedule"></textarea>
            </div>

            <div id="classInfoSection">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Course:</label>
                        <select name="course_name" class="w-full p-2 border rounded">
                            <option value="">Select Course</option>
                            <!-- Courses will be populated dynamically via JavaScript -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Class Group:</label>
                        <select name="class_group" class="w-full p-2 border rounded">
                            <option value="">Select Class</option>
                            <!-- Classes will be populated dynamically via JavaScript -->
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Date:</label>
                    <input type="date" name="date" class="w-full p-2 border rounded" required min="{{ date('Y-m-d') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Recurrence Pattern:</label>
                    <select name="recurrence" id="recurrenceSelect" class="w-full p-2 border rounded" onchange="toggleRecurrenceOptions()">
                        <option value="none">Does not repeat</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly on selected days</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>

                <div id="weeklyOptions" class="hidden mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Days of Week</label>
                    <div class="flex flex-wrap gap-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="days[]" value="monday" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Mon</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="days[]" value="tuesday" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Tue</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="days[]" value="wednesday" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Wed</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="days[]" value="thursday" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Thu</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="days[]" value="friday" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Fri</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="days[]" value="saturday" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Sat</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Recurrence End Date:</label>
                    <input type="date" name="recurrence_end" class="w-full p-2 border rounded" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Start Time:</label>
                    <input type="time" name="start_time" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">End Time:</label>
                    <input type="time" name="end_time" class="w-full p-2 border rounded" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Location:</label>
                <input type="text" name="location" class="w-full p-2 border rounded" placeholder="e.g. Room 205, Online, Science Building">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded" onclick="closeAddScheduleModal()">Cancel</button>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Save Schedule</button>
            </div>
        </form>
    </div>
</div>



  <!-- View Attendance Report Modal -->
  <div id="attendanceReportModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Faculty Attendance Reports</h2>
        <button onclick="closeAttendanceReportModal()" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <div class="mb-4 flex justify-between items-center">
        <div class="flex space-x-2">
            <select class="p-2 border rounded text-3xl">
                <option>All Departments</option>
                <option>Science Department</option>
                <option>Mathematics Department</option>
                <option>English Department</option>
                <option>Social Studies Department</option>
                <option>Arts Department</option>
            </select>

            <select class="p-2 border rounded text-2xl">
                <option>April 2025</option>
                <option>March 2025</option>
                <option>February 2025</option>
                <option>January 2025</option>
            </select>
        </div>

        <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded text-xl">Export to Excel</button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-xl">
                    <th class="py-4 px-6 text-left">Teacher Name</th>
                    <th class="py-4 px-6 text-left">Department</th>
                    <th class="py-4 px-6 text-center">Events Attended</th>
                    <th class="py-4 px-6 text-center">Events Missed</th>
                    <th class="py-4 px-6 text-center">Attendance Rate</th>
                    <th class="py-4 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-xl">
                <tr class="border-b">
                    <td class="py-4 px-6">Dr. Amanda Johnson</td>
                    <td class="py-4 px-6">Science</td>
                    <td class="py-4 px-6 text-center">12</td>
                    <td class="py-4 px-6 text-center">1</td>
                    <td class="py-4 px-6 text-center">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full" style="width: 92%"></div>
                        </div>
                        <span class="text-3xl">92%</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <button class="text-blue-500 hover:text-blue-700 text-xl">View Details</button>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-4 px-6">Mr. Robert Chen</td>
                    <td class="py-4 px-6">Mathematics</td>
                    <td class="py-4 px-6 text-center">10</td>
                    <td class="py-4 px-6 text-center">3</td>
                    <td class="py-4 px-6 text-center">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full" style="width: 77%"></div>
                        </div>
                        <span class="text-3xl">77%</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <button class="text-blue-500 hover:text-blue-700 text-xl">View Details</button>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-4 px-6">Ms. Sarah Williams</td>
                    <td class="py-4 px-6">English</td>
                    <td class="py-4 px-6 text-center">13</td>
                    <td class="py-4 px-6 text-center">0</td>
                    <td class="py-4 px-6 text-center">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full" style="width: 100%"></div>
                        </div>
                        <span class="text-3xl">100%</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <button class="text-blue-500 hover:text-blue-700 text-xl">View Details</button>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-4 px-6">Mr. David Miller</td>
                    <td class="py-4 px-6">Social Studies</td>
                    <td class="py-4 px-6 text-center">8</td>
                    <td class="py-4 px-6 text-center">5</td>
                    <td class="py-4 px-6 text-center">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-yellow-500 h-3 rounded-full" style="width: 62%"></div>
                        </div>
                        <span class="text-3xl">62%</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <button class="text-blue-500 hover:text-blue-700 text-xl">View Details</button>
                    </td>
                </tr>

                <tr>
                    <td class="py-4 px-6">Mrs. Emily Parker</td>
                    <td class="py-4 px-6">Arts</td>
                    <td class="py-4 px-6 text-center">9</td>
                    <td class="py-4 px-6 text-center">4</td>
                    <td class="py-4 px-6 text-center">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-yellow-500 h-3 rounded-full" style="width: 69%"></div>
                        </div>
                        <span class="text-3xl">69%</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <button class="text-blue-500 hover:text-blue-700 text-xl">View Details</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  <!-- Schedule Details Modal -->
  <div id="scheduleDetailsModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Schedule Details</h2>
        <button onclick="closeScheduleDetailsModal()" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <div class="mb-6">
        <h3 class="text-xl font-semibold text-green-700 mb-2">Department Review</h3>
        <p class="text-gray-600 mb-2">Quarterly review of department performance and curriculum planning</p>

        <div class="grid grid-cols-2 gap-4 mt-4">
          <div>
            <p class="text-gray-500 text-2xl">Date:</p>
            <p class="font-medium">April 2, 2025</p>
          </div>
          <div>
            <p class="text-gray-500 text-2xl">Time:</p>
            <p class="font-medium">2:00 PM - 4:00 PM</p>
          </div>
          <div>
            <p class="text-gray-500 text-2xl">Location:</p>
            <p class="font-medium">Conference Room B</p>
          </div>
          <div>
            <p class="text-gray-500 text-2xl">Assigned to:</p>
            <p class="font-medium">All Faculty</p>
          </div>
        </div>
      </div>

      <div class="mb-6">
        <h4 class="font-semibold text-gray-700 mb-2">Attendance</h4>
        <div class="bg-gray-50 p-4 rounded-lg">
          <div class="flex justify-between items-center mb-2">
            <span class="font-medium">Total Assigned: 15 teachers</span>
            <span class="font-medium">Present: 12 (80%)</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
            <div class="bg-green-600 h-2.5 rounded-full" style="width: 80%"></div>
          </div>

          <div class="mt-2">
            <p class="text-2xl text-gray-500 mb-1">Absent:</p>
            <ul class="text-2xl ml-5 list-disc">
              <li>Mr. David Miller (Social Studies)</li>
              <li>Mrs. Emily Parker (Arts)</li>
              <li>Dr. Michael Brown (Science)</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="flex justify-between">
        <div>
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mr-2">Mark Attendance</button>
          <button class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-2 rounded">Send Reminder</button>
        </div>
        <div>
          <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded mr-2">Edit</button>
          <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <div id="scheduleDetailsModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-2xl font-bold"></h2>
            <button onclick="document.getElementById('scheduleDetailsModal').classList.add('hidden')"
                    class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <p id="modalDateTime" class="text-xl"></p>
            <p id="modalType" class="text-xl"></p>
            <p id="modalTeacher" class="text-xl"></p>
            <p id="modalLocation" class="text-xl"></p>
            <p id="modalCourse" class="text-xl"></p>
            <p id="modalClassGroup" class="text-xl"></p>

            <div class="mt-4">
                <h3 class="text-xl font-semibold">Description:</h3>
                <p id="modalDescription" class="text-xl"></p>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button onclick="document.getElementById('scheduleDetailsModal').classList.add('hidden')"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Close
            </button>
        </div>
    </div>
</div>

  <script>

    function openAddScheduleModal() {
      document.getElementById('addScheduleModal').classList.remove('hidden');
    }

    function closeAddScheduleModal() {
      document.getElementById('addScheduleModal').classList.add('hidden');
    }

    function openAttendanceReportModal() {
      document.getElementById('attendanceReportModal').classList.remove('hidden');
    }

    function closeAttendanceReportModal() {
      document.getElementById('attendanceReportModal').classList.add('hidden');
    }

    function viewScheduleDetails(id) {
      document.getElementById('scheduleDetailsModal').classList.remove('hidden');
    }

    function closeScheduleDetailsModal() {
      document.getElementById('scheduleDetailsModal').classList.add('hidden');
    }


    function assignTypeChange(value) {
      const departmentSelect = document.getElementById('departmentSelection');
      const teacherSelect = document.getElementById('teacherSelection');

      if (value === 'department') {
        departmentSelect.classList.remove('hidden');
        teacherSelect.classList.add('hidden');
      } else if (value === 'individual') {
        departmentSelect.classList.add('hidden');
        teacherSelect.classList.remove('hidden');
      } else {
        departmentSelect.classList.add('hidden');
        teacherSelect.classList.add('hidden');
      }
    }

    function scheduleTypeChange(value) {

    }
  </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentDate = new Date();

        const prevMonthBtn = document.querySelector('.flex.border.rounded.overflow-hidden button:first-child');
        const nextMonthBtn = document.querySelector('.flex.border.rounded.overflow-hidden button:last-child');
        const monthYearDisplay = document.querySelector('.flex.border.rounded.overflow-hidden span');
        const calendarGrid = document.getElementById('calendarGrid');
        const todayButton = document.querySelector('button.bg-blue-500');


        const monthNames = ["January", "February", "March", "April", "May", "June", "July",
                          "August", "September", "October", "November", "December"];


        let events = [];
        fetchSchedules();

        // Add event listeners for navigation
        prevMonthBtn.addEventListener('click', () => changeMonth(-1));
        nextMonthBtn.addEventListener('click', () => changeMonth(1));
        todayButton.addEventListener('click', goToToday);

        function fetchSchedules() {
            fetch("{{ route('calendar.schedules') }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    events = data;
                    renderCalendar();
                })
                .catch(error => {
                    console.error('Error fetching schedules:', error);
                    renderCalendar();
                });
        }

        function changeMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            renderCalendar();
        }

        function goToToday() {
            currentDate = new Date();
            renderCalendar();
        }

        function renderCalendar() {

            monthYearDisplay.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

            calendarGrid.innerHTML = '';

            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            let startDay = firstDay.getDay() - 1;
            if (startDay < 0) startDay = 6;
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

            let dayCount = 1;
            for (let row = 0; row < 6; row++) {
                for (let col = 0; col < 7; col++) {
                    const dayCell = document.createElement('div');
                    dayCell.className = 'p-2 border border-gray-200 min-h-40';

                    if (row === 0 && col < startDay) {
                        dayCell.textContent = '';
                    } else if (dayCount > lastDay) {
                        dayCell.textContent = '';
                    } else {
                        const dayNum = document.createElement('p');
                        dayNum.className = 'text-2xl font-bold mb-1';
                        dayNum.textContent = dayCount;
                        dayCell.appendChild(dayNum);

                        const dateStr = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(dayCount).padStart(2, '0')}`;

                        const dayEvents = events.filter(event => event.date === dateStr);
                        dayEvents.forEach(event => {
                            const eventEl = document.createElement('div');
                            eventEl.className = `p-1 rounded ${event.color} cursor-pointer mb-1`;
                            eventEl.onclick = () => viewScheduleDetails(event.id);

                            const eventTitle = document.createElement('p');
                            eventTitle.className = 'text-2xl font-semibold truncate';
                            eventTitle.textContent = event.title;

                            const eventTime = document.createElement('p');
                            eventTime.className = 'text-2xl';
                            eventTime.textContent = event.time;

                            eventEl.appendChild(eventTitle);
                            eventEl.appendChild(eventTime);
                            dayCell.appendChild(eventEl);
                        });

                        dayCount++;
                    }
                    calendarGrid.appendChild(dayCell);
                }
            }
        }

        window.viewScheduleDetails = function (id) {
            fetch(`/calendar/schedule/${id}`)
                .then(response => response.json())
                .then(schedule => {

                    document.getElementById('modalTitle').textContent = schedule.title;
                    document.getElementById('modalDateTime').textContent =
                        `${schedule.date} • ${schedule.time}`;
                    document.getElementById('modalType').textContent =
                        `Type: ${schedule.type.replace(/_/g, ' ')}`;
                    document.getElementById('modalTeacher').textContent =
                        `Teacher: ${schedule.teacher}`;
                    document.getElementById('modalLocation').textContent =
                        `Location: ${schedule.location}`;
                    document.getElementById('modalDescription').textContent =
                        schedule.description || 'No description provided';
                    document.getElementById('modalCourse').textContent =
                        `Course: ${schedule.course_name || 'N/A'}`;
                    document.getElementById('modalClassGroup').textContent =
                        `Class Group: ${schedule.class_group || 'N/A'}`;

                    // Show modal
                    document.getElementById('scheduleDetailsModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching schedule details:', error);
                    alert('Failed to load schedule details');
                });
        };
    });
</script>
<script>

function openAddScheduleModal() {
    document.getElementById('addScheduleModal').classList.remove('hidden');

    const now = new Date();
    const later = new Date(now.getTime() + 60 * 60 * 1000);

    document.querySelector('input[name="start_time"]').value = now.toTimeString().substring(0, 5);
    document.querySelector('input[name="end_time"]').value = later.toTimeString().substring(0, 5);
    document.querySelector('input[name="date"]').valueAsDate = now;
    document.querySelector('input[name="recurrence_end"]').valueAsDate = new Date(now.getTime() + 30 * 24 * 60 * 60 * 1000); // 30 days later
}

function closeAddScheduleModal() {
    document.getElementById('addScheduleModal').classList.add('hidden');
    document.getElementById('scheduleForm').reset();
}


document.querySelector('select[name="teacher_id"]')?.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const workingHours = selectedOption.getAttribute('data-working-hours');
    const courses = selectedOption.getAttribute('data-courses');
    const classes = selectedOption.getAttribute('data-classes');


    const workingHoursElement = document.getElementById('teacherWorkingHours');
    workingHoursElement.textContent = workingHours ? `Working Hours: ${workingHours}` : '';
    workingHoursElement.classList.toggle('hidden', !workingHours);

    const courseSelect = document.querySelector('select[name="course_name"]');
    courseSelect.innerHTML = '<option value="">Select Course</option>';

    if (courses) {
        try {
            const courseList = typeof courses === 'string' ? courses.split(',') : JSON.parse(courses);
            courseList.forEach(course => {
                if (course && course.trim()) {
                    const option = document.createElement('option');
                    option.value = course.trim();
                    option.textContent = course.trim();
                    courseSelect.appendChild(option);
                }
            });
        } catch (e) {
            console.error("Error parsing courses:", e);
            courses.split(',').forEach(course => {
                if (course.trim()) {
                    const option = document.createElement('option');
                    option.value = course.trim();
                    option.textContent = course.trim();
                    courseSelect.appendChild(option);
                }
            });
        }
    }

    const classSelect = document.querySelector('select[name="class_group"]');
    classSelect.innerHTML = '<option value="">Select Class</option>';

    if (classes) {
        try {
            const classList = typeof classes === 'string' ? classes.split(',') : JSON.parse(classes);
            classList.forEach(cls => {
                if (cls && cls.trim()) {
                    const option = document.createElement('option');
                    option.value = cls.trim();
                    option.textContent = cls.trim();
                    classSelect.appendChild(option);
                }
            });
        } catch (e) {
            console.error("Error parsing classes:", e);

            classes.split(',').forEach(cls => {
                if (cls.trim()) {
                    const option = document.createElement('option');
                    option.value = cls.trim();
                    option.textContent = cls.trim();
                    classSelect.appendChild(option);
                }
            });
        }
    }
});

// Schedule type change handler
document.querySelector('select[name="schedule_type"]')?.addEventListener('change', function() {
    const classInfoSection = document.getElementById('classInfoSection');


    classInfoSection.classList.toggle('hidden', this.value !== 'class');
});

function toggleRecurrenceOptions() {
    const recurrenceSelect = document.getElementById('recurrenceSelect');
    const weeklyOptions = document.getElementById('weeklyOptions');
    const recurrenceEndField = document.querySelector('input[name="recurrence_end"]');

    if (recurrenceSelect.value === 'weekly') {
        weeklyOptions.classList.remove('hidden');
        recurrenceEndField.required = true;
    } else {
        weeklyOptions.classList.add('hidden');
        if (recurrenceSelect.value === 'none') {
            recurrenceEndField.required = false;
        } else {
            recurrenceEndField.required = true;
        }
    }
}


document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('recurrenceSelect')?.addEventListener('change', toggleRecurrenceOptions);
    toggleRecurrenceOptions();


    if (!document.querySelector('input[name="start_time"]').value) {
        const now = new Date();
        const later = new Date(now.getTime() + 60 * 60 * 1000);

        document.querySelector('input[name="start_time"]').value = now.toTimeString().substring(0, 5);
        document.querySelector('input[name="end_time"]').value = later.toTimeString().substring(0, 5);
        document.querySelector('input[name="date"]').valueAsDate = now;
        document.querySelector('input[name="recurrence_end"]').valueAsDate = new Date(now.getTime() + 30 * 24 * 60 * 60 * 1000);
    }


    document.getElementById('scheduleForm')?.addEventListener('submit', function(e) {

    });
});
    </script>
@endsection

