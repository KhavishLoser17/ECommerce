
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Schedule Calendar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        #calendar {
            max-width: 100%;
            margin: 0 auto;
            min-height: 500px;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed {
            width: 80px;
        }

        .sidebar-expanded {
            width: 250px;
        }

        .content-area {
            transition: all 0.3s ease;
            margin-left: 250px; /* Initial state - sidebar expanded */
        }

        .content-area-expanded {
            margin-left: 80px;
        }

        .dropdown-menu {
            display: none;
        }

        .menu-item:hover .dropdown-menu {
            display: block;
        }

        .submenu-item {
            padding-left: 2.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-visible {
                transform: translateX(0);
            }

            .content-area {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar bg-sky-500 text-white z-50 sidebar-expanded overflow-y-auto">
            <!-- Logo Section -->
            <div class="px-4 py-4 border-b border-sky-800">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.index') }}" class="flex items-center space-x-2">
                        <img id="logo_header" alt="Bestlink College Logo"
                            src="{{ asset('images/logo/logo1.png') }}"
                            class="w-10 h-auto">
                        <span class="text-sm font-semibold whitespace-nowrap sidebar-text">Bestlink College of The <br>Philippines</span>
                    </a>
                    <button id="toggle-sidebar" class="text-white p-2 rounded hover:bg-blue-600">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Menu Section -->
            <div class="py-4">
                <!-- Dashboard Link -->
                <div class="px-4 py-2 text-xs uppercase tracking-wider text-blue-200 sidebar-text">
                    Main Menu
                </div>
                <a href="{{route('admin.index')}}" class="flex items-center px-4 py-3 text-white hover:bg-blue-600 transition">
                    <i class="fas fa-tachometer-alt w-6 text-center"></i>
                    <span class="ml-3 sidebar-text">Dashboard</span>
                </a>

                <!-- Faculty Members Section -->
                <div class="mt-4">
                    <div class="px-4 py-2 text-xs uppercase tracking-wider text-blue-200 sidebar-text">
                        Management
                    </div>

                    <!-- Faculty Members Dropdown -->
                    <div class="menu-item">
                        <a href="#" class="flex items-center justify-between px-4 py-3 text-white hover:bg-blue-600 transition">
                            <div class="flex items-center">
                                <i class="fas fa-users w-6 text-center"></i>
                                <span class="ml-3 sidebar-text">Faculty Members</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs sidebar-text"></i>
                        </a>
                        <div class="dropdown-menu bg-blue-800 py-2">
                            <a href="{{route('admin.teacher')}}" class="flex items-center px-4 py-2 text-white hover:bg-blue-600">
                                <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                                <span class="ml-3 sidebar-text">Teachers</span>
                            </a>
                            <a href="{{route('admin.staff')}}" class="flex items-center px-4 py-2 text-white hover:bg-blue-600">
                                <i class="fas fa-user-tie w-6 text-center"></i>
                                <span class="ml-3 sidebar-text">Staffs</span>
                            </a>
                        </div>
                    </div>

                    <!-- Schedules Dropdown -->
                    <div class="menu-item">
                        <a href="#" class="flex items-center justify-between px-4 py-3 text-white hover:bg-blue-600 transition">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt w-6 text-center"></i>
                                <span class="ml-3 sidebar-text">Schedules</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs sidebar-text"></i>
                        </a>
                        <div class="dropdown-menu bg-blue-800 py-2">
                            <a href="{{route('admin.faculty-attendance')}}" class="flex items-center px-4 py-2 text-white hover:bg-blue-600">
                                <i class="fas fa-clock w-6 text-center"></i>
                                <span class="ml-3 sidebar-text">Faculties Schedule</span>
                            </a>
                            <a href="{{route('admin.schedule')}}" class="flex items-center px-4 py-2 text-white hover:bg-blue-600">
                                <i class="fas fa-bullhorn w-6 text-center"></i>
                                <span class="ml-3 sidebar-text">Announcement Schedule</span>
                            </a>
                        </div>
                    </div>

                    <!-- Other Menu Items -->
                    <a href="{{route('admin.makeup')}}" class="flex items-center px-4 py-3 text-white hover:bg-blue-600 transition">
                        <i class="fas fa-chalkboard w-6 text-center"></i>
                        <span class="ml-3 sidebar-text">Makeup-Class</span>
                    </a>

                    <a href="{{route('admin.event')}}" class="flex items-center px-4 py-3 text-white hover:bg-blue-600 transition">
                        <i class="fas fa-calendar-check w-6 text-center"></i>
                        <span class="ml-3 sidebar-text">Event Management</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 text-white hover:bg-blue-600 transition">
                        <i class="fas fa-money-bill-wave w-6 text-center"></i>
                        <span class="ml-3 sidebar-text">Payroll</span>
                    </a>
                </div>

                <!-- Logout Section -->
                <div class="mt-auto pt-4 border-t border-blue-800">
                    <form method="POST" action="{{route('logout')}}" id="logout-form">
                        @csrf
                        <a href="{{route('logout')}}"
                           class="flex items-center px-4 py-3 text-white hover:bg-blue-600 transition"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt w-6 text-center"></i>
                            <span class="ml-3 sidebar-text">Logout</span>
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div id="content-area" class="content-area flex-1">
            <!-- Top Navigation Bar -->
            <div class="bg-white shadow-md">
                <div class="container mx-auto px-4">
                    <div class="flex items-center justify-between h-16">
                        <!-- Mobile menu button -->
                        <button id="mobile-menu-button" class="md:hidden text-gray-700">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <!-- Page Title - Only shown on mobile -->
                        <h1 class="md:hidden text-lg font-semibold text-gray-800">Teacher Schedule</h1>

                        <!-- Right-aligned icons -->
                        <div class="flex items-center space-x-4 ml-auto">
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="text-gray-700 relative">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">1</span>
                                </button>
                            </div>

                            <!-- User Profile -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2">
                                    <img src="{{ asset('images/avatar/crim1.jpg') }}" alt="User Profile"
                                        class="w-8 h-8 rounded-full object-cover">
                                    <span class="hidden md:block text-gray-700">Admin User</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                                </button>

                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block z-50">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i> Settings
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="container mx-auto px-4 py-6">
                <!-- Page Header - Hidden on mobile -->
                <div class="hidden md:flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Teacher Schedule Calendar</h1>
                    <!-- Add Schedule Button -->
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md">
                        <i class="fas fa-plus mr-2"></i> Add Schedule
                    </button>
                </div>

                <!-- Calendar Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <!-- Dropdown for Teacher Selection -->
                    <div class="mb-6 flex flex-col md:flex-row md:items-center">
                        <label for="teacher-select" class="mb-2 md:mb-0 md:mr-4 text-gray-700 font-medium">Select Teacher:</label>
                        <select id="teacher-select" class="border p-2 rounded-md text-gray-700 w-full md:w-auto">
                            <option value="all">All Teachers</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->title }} {{ $teacher->first_name }} {{ $teacher->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Calendar -->
                    <div id="calendar"></div>
                </div>
            </div>
                    <!-- Teacher Schedule Modal -->
        <div id="scheduleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 h-3/4 overflow-hidden">
                <div class="flex justify-between items-center border-b px-6 py-4">
                    <h3 class="text-xl font-bold text-gray-800">Teacher Schedule</h3>
                    <button id="closeScheduleModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4 h-full flex flex-col">
                    <!-- View Selector -->
                    <div class="flex space-x-2 mb-4">
                        <button id="dayViewBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md">Day</button>
                        <button id="weekViewBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">Week</button>
                        <button id="monthViewBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">Month</button>
                    </div>

                    <!-- Calendar Container -->
                    <div id="teacherCalendar" class="flex-grow"></div>
                </div>
            </div>
        </div>

            <!-- Footer -->
            <div class="bg-white border-t mt-auto py-4">
                <div class="container mx-auto px-4 text-center">
                    <p class="text-gray-600">Created by Students of Bestlink College of The Philippines</p>
                </div>
            </div>
        </div>
    </div>
{{--
    <script>
   document.addEventListener('DOMContentLoaded', function() {
    // Check if FullCalendar is properly loaded
    if (typeof FullCalendar === 'undefined') {
        console.error('FullCalendar not loaded properly');
        return;
    }

    try {
        var calendarEl = document.getElementById('calendar');
        if (!calendarEl) {
            console.error('Calendar element not found');
            return;
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: []
        });
        calendar.render();
    } catch (error) {
        console.error('Calendar initialization error:', error);
        Swal.fire('Error', 'Could not initialize calendar', 'error');
    }

    // Teacher Schedule Modal Elements
    const scheduleModal = document.getElementById('scheduleModal');
    const closeScheduleModal = document.getElementById('closeScheduleModal');
    const addScheduleBtn = document.querySelector('.bg-blue-600');

    if (!scheduleModal || !closeScheduleModal || !addScheduleBtn) {
        console.error('Required modal elements not found');
        return;
    }

    // Teacher Calendar Instance
    let teacherCalendar = null;
    let currentTeacherId = null;
    let currentTeacherData = null;

    // Initialize teacher calendar
    function initTeacherCalendar(teacherId, initialView = 'timeGridDay') {
        const teacherCalEl = document.getElementById('teacherCalendar');
        if (!teacherCalEl) return;

        // Fetch teacher data first
        fetch(`/teachers/${teacherId}`)
            .then(response => response.json())
            .then(teacher => {
                currentTeacherData = teacher;

                if (teacherCalendar) {
                    teacherCalendar.destroy();
                }

                teacherCalendar = new FullCalendar.Calendar(teacherCalEl, {
                    initialView: initialView,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: function(fetchInfo, successCallback, failureCallback) {
                        fetch(`/schedules/${teacherId}?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => successCallback(data))
                        .catch(error => {
                            console.error('Error fetching schedules:', error);
                            failureCallback(error);
                        });
                    },
                    dateClick: function(info) {
                        handleDateClick(info, teacherId);
                    },
                    eventClick: function(info) {
                        handleEventClick(info);
                    }
                });

                teacherCalendar.render();
                currentTeacherId = teacherId;
                updateActiveViewButton(initialView === 'timeGridDay' ? 'day' :
                                     initialView === 'timeGridWeek' ? 'week' : 'month');
            })
            .catch(error => {
                console.error('Error fetching teacher:', error);
                Swal.fire('Error', 'Failed to load teacher data', 'error');
            });
    }

    // Handle date click for new events
    function handleDateClick(info, teacherId) {
    if (!currentTeacherData) {
        Swal.fire('Error', 'Teacher data not loaded', 'error');
        return;
    }

    // Class title options (you can fetch these from server if needed)
    const classTitles = [
        'Lecture',
        'Lab Session',
        'Tutorial',
        'Workshop',
        'Seminar',
        'Exam'
    ];

    // Room options
    const roomOptions = [
        'Room 101',
        'Room 102',
        'Room 201',
        'Room 202',
        'Lab 1',
        'Lab 2'
    ];

    // Grade options
    const gradeOptions = [
        '1st Year',
        '2nd Year',
        '3rd Year',
        '4th Year'
    ];

    Swal.fire({
        title: `Schedule for ${currentTeacherData.title} ${currentTeacherData.first_name} ${currentTeacherData.last_name}`,
        html: `
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Course: ${currentTeacherData.course}</label>
                <input id="course_code" class="swal2-input" placeholder="Course Code (e.g., MATH101)" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Class Type</label>
                <select id="class_title" class="swal2-select" required>
                    ${classTitles.map(title => `<option value="${title}">${title}</option>`).join('')}
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea id="description" class="swal2-textarea" placeholder="Class description"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Start Time</label>
                    <input id="start" class="swal2-input" type="datetime-local" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">End Time</label>
                    <input id="end" class="swal2-input" type="datetime-local" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Room</label>
                    <select id="room" class="swal2-select" required>
                        ${roomOptions.map(room => `<option value="${room}">${room}</option>`).join('')}
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Grade Level</label>
                    <select id="grade" class="swal2-select" required>
                        ${gradeOptions.map(grade => `<option value="${grade}">${grade}</option>`).join('')}
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Color</label>
                <input id="color" class="swal2-input" type="color" value="#3b82f6">
            </div>

            <div class="text-sm text-gray-500 mt-2">
                Teacher Availability: ${currentTeacherData.working_hours_start} to ${currentTeacherData.working_hours_end}
            </div>
        `,
        focusConfirm: false,
        preConfirm: () => {
            const start = document.getElementById('start').value;
            const end = document.getElementById('end').value;

            // Validate time duration (minimum 30 minutes, maximum 4 hours)
            const startTime = new Date(start);
            const endTime = new Date(end);
            const duration = (endTime - startTime) / (1000 * 60); // in minutes

            if (duration < 30) {
                Swal.showValidationMessage('Minimum duration is 30 minutes');
                return false;
            }

            if (duration > 240) {
                Swal.showValidationMessage('Maximum duration is 4 hours');
                return false;
            }

            return {
                teacher_id: teacherId,
                course_code: document.getElementById('course_code').value,
                class_title: document.getElementById('class_title').value,
                description: document.getElementById('description').value,
                start_time: start,
                end_time: end,
                room: document.getElementById('room').value,
                grade: document.getElementById('grade').value,
                color: document.getElementById('color').value
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            saveSchedule(result.value);
        }
    });

    // Set default times with working hours enforcement
    setTimeout(() => {
        const startEl = document.getElementById('start');
        const endEl = document.getElementById('end');

        if (startEl && endEl) {
            const clickedDate = new Date(info.date);
            const [startHour, startMinute] = currentTeacherData.working_hours_start.split(':');
            const [endHour, endMinute] = currentTeacherData.working_hours_end.split(':');

            // Set default start time (either clicked time or teacher's start time, whichever is later)
            const defaultStart = new Date(clickedDate);
            defaultStart.setHours(Math.max(clickedDate.getHours(), startHour), Math.max(clickedDate.getMinutes(), startMinute));

            // Set default end time (2 hours later, but not beyond teacher's end time)
            const defaultEnd = new Date(defaultStart);
            defaultEnd.setHours(defaultStart.getHours() + 2);

            // Adjust if exceeds teacher's working hours
            if (defaultEnd.getHours() > endHour ||
                (defaultEnd.getHours() == endHour && defaultEnd.getMinutes() > endMinute)) {
                defaultEnd.setHours(endHour, endMinute);
            }

            // Format for datetime-local input
            startEl.value = formatDateTimeLocal(defaultStart);
            endEl.value = formatDateTimeLocal(defaultEnd);
        }
    }, 100);
}

function formatDateTimeLocal(date) {
    return date.toISOString().slice(0, 16);
}

    // Save schedule to database
    function saveSchedule(scheduleData) {
        fetch('/schedules', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(scheduleData)
        })
        .then(response => {
            if (!response.ok) throw new Error('Failed to save');
            return response.json();
        })
        .then(data => {
            if (data.success && teacherCalendar) {
                teacherCalendar.refetchEvents();
                Swal.fire('Success!', 'Schedule added successfully', 'success');
            }
        })
        .catch(error => {
            console.error('Error saving schedule:', error);
            Swal.fire('Error!', 'Failed to save schedule', 'error');
        });
    }

    // Handle event clicks
    function handleEventClick(info) {
        Swal.fire({
            title: info.event.title,
            html: `
                <p><strong>Course Code:</strong> ${info.event.extendedProps.course_code || 'N/A'}</p>
                <p><strong>Time:</strong> ${info.event.start.toLocaleString()} - ${info.event.end.toLocaleString()}</p>
                <p><strong>Room:</strong> ${info.event.extendedProps.room || 'N/A'}</p>
                <p><strong>Grade:</strong> ${info.event.extendedProps.grade || 'N/A'}</p>
                <p><strong>Description:</strong> ${info.event.extendedProps.description || 'N/A'}</p>
            `,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Close',
            confirmButtonColor: '#ef4444'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteSchedule(info.event.id);
            }
        });
    }

    // Delete schedule
    function deleteSchedule(eventId) {
        fetch(`/schedules/${eventId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Failed to delete');
            return response.json();
        })
        .then(data => {
            if (data.success && teacherCalendar) {
                teacherCalendar.refetchEvents();
                Swal.fire('Deleted!', 'Schedule deleted successfully', 'success');
            }
        })
        .catch(error => {
            console.error('Error deleting schedule:', error);
            Swal.fire('Error!', 'Failed to delete schedule', 'error');
        });
    }

    // Open modal with teacher schedule
    function openTeacherSchedule(teacherId) {
        if (!teacherId) {
            Swal.fire('Error', 'Please select a teacher first', 'error');
            return;
        }
        initTeacherCalendar(teacherId);
        scheduleModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Close modal
    function closeTeacherSchedule() {
        scheduleModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Update active view button style
    function updateActiveViewButton(activeView) {
        const views = ['day', 'week', 'month'];
        views.forEach(view => {
            const btn = document.getElementById(`${view}ViewBtn`);
            if (btn) {
                btn.classList.toggle('bg-blue-600', view === activeView);
                btn.classList.toggle('text-white', view === activeView);
                btn.classList.toggle('bg-gray-200', view !== activeView);
                btn.classList.toggle('text-gray-700', view !== activeView);
            }
        });
    }

    // Event listeners
    addScheduleBtn?.addEventListener('click', () => {
        const selectedTeacher = document.getElementById('teacher-select')?.value;
        openTeacherSchedule(selectedTeacher);
    });

    closeScheduleModal?.addEventListener('click', closeTeacherSchedule);

    // View switch buttons
    ['day', 'week', 'month'].forEach(view => {
        const btn = document.getElementById(`${view}ViewBtn`);
        btn?.addEventListener('click', () => {
            if (teacherCalendar && currentTeacherId) {
                teacherCalendar.changeView(
                    view === 'day' ? 'timeGridDay' :
                    view === 'week' ? 'timeGridWeek' : 'dayGridMonth'
                );
                updateActiveViewButton(view);
            }
        });
    });

    // Initialize with day view active
    updateActiveViewButton('day');
});
    </script> --}}

</body>
</html>
