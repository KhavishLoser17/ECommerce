<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function schedule(){
        return view('admin.schedule');
    }

    public function create()
    {
        // Get unique departments from teachers
        $departments = Teacher::select('course')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        $teachers = Teacher::orderBy('last_name')->get();

        return view('admin.schedule', compact('departments', 'teachers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:teachers,id',
            'schedule_type' => 'required|in:class,office_hours,meeting,development,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_name' => 'nullable|string|max:255', // Made this optional for all schedule types
            'class_group' => 'nullable|string|max:50',
            'date' => 'required|date|after_or_equal:today',
            'recurrence' => 'required|in:none,daily,weekly,monthly',
            'days' => 'required_if:recurrence,weekly|array',
            'days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'recurrence_end' => 'required_if:recurrence,daily,weekly,monthly|date|after_or_equal:date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Check teacher availability for initial date
        if (!$this->isTeacherAvailable($validated['teacher_id'], $validated['date'],
            $validated['start_time'], $validated['end_time'])) {
            return back()->withErrors(['time' => 'The teacher is not available during the requested time.'])->withInput();
        }

        // Create the base schedule data
        $scheduleData = [
            'teacher_id' => $validated['teacher_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'schedule_type' => $validated['schedule_type'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'],
            'recurrence' => $validated['recurrence'],
            'days_of_week' => isset($validated['days'])
                ? implode(',', $validated['days'])
                : null,
            'recurrence_end' => $validated['recurrence'] !== 'none'
                ? $validated['recurrence_end']
                : null,
        ];

        // Explicitly set course_name and class_group
        $scheduleData['course_name'] = $request->input('course_name');
        $scheduleData['class_group'] = $request->input('class_group');

        // Create the schedule
        $schedule = Schedule::create($scheduleData);

        // Generate recurring schedules if needed
        if ($validated['recurrence'] !== 'none') {
            $this->generateRecurringSchedules($schedule);
        }

        return redirect()->route('admin.schedule')->with('success', 'Schedule created successfully.');
    }

    private function generateRecurringSchedules(Schedule $masterSchedule)
    {
        $startDate = Carbon::parse($masterSchedule->date);
        $endDate = Carbon::parse($masterSchedule->recurrence_end);
        $currentDate = $startDate->copy()->addDay();

        $schedules = [];

        while ($currentDate->lte($endDate)) {
            if ($this->shouldCreateSchedule($masterSchedule, $currentDate)) {
                // Check teacher availability for this date
                if ($this->isTeacherAvailable(
                    $masterSchedule->teacher_id,
                    $currentDate->format('Y-m-d'),
                    $masterSchedule->start_time,
                    $masterSchedule->end_time
                )) {
                    $schedules[] = [
                        'teacher_id' => $masterSchedule->teacher_id,
                        'title' => $masterSchedule->title,
                        'description' => $masterSchedule->description,
                        'schedule_type' => $masterSchedule->schedule_type,
                        'date' => $currentDate->format('Y-m-d'),
                        'start_time' => $masterSchedule->start_time,
                        'end_time' => $masterSchedule->end_time,
                        'location' => $masterSchedule->location,
                        'course_name' => $masterSchedule->course_name,
                        'class_group' => $masterSchedule->class_group,
                        'recurrence' => 'none',
                        'master_schedule_id' => $masterSchedule->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            $currentDate->addDay();

            if ($masterSchedule->recurrence === 'monthly') {
                $currentDate = $startDate->copy()->addMonth($currentDate->diffInMonths($startDate) + 1)->day($startDate->day);
            }
        }

        // Insert all generated schedules in one query
        if (!empty($schedules)) {
            Schedule::insert($schedules);
        }
    }

    private function shouldCreateSchedule(Schedule $masterSchedule, Carbon $date)
    {
        // Skip if date is same as master schedule date (already created)
        if ($date->format('Y-m-d') === $masterSchedule->date) {
            return false;
        }

        if ($masterSchedule->recurrence === 'daily') {
            return true;
        }

        if ($masterSchedule->recurrence === 'weekly') {
            $dayName = strtolower($date->format('l'));
            $days = explode(',', $masterSchedule->days_of_week);
            return in_array($dayName, $days);
        }

        if ($masterSchedule->recurrence === 'monthly') {
            return $date->day === Carbon::parse($masterSchedule->date)->day;
        }

        return false;
    }

    private function isTeacherAvailable($teacherId, $date, $startTime, $endTime)
    {
        // Just check for any existing schedule at this time
        return !Schedule::where('teacher_id', $teacherId)
            ->where('date', $date)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->exists();
    }
    public function getSchedules()
    {
        $schedules = Schedule::with('teacher')
            ->get()
            ->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'title' => $schedule->title,
                    'time' => $schedule->formatted_time,
                    'type' => $schedule->schedule_type,
                    'teacher' => $schedule->teacher_full_name,
                    'date' => $schedule->date,
                    'location' => $schedule->location,
                    'color' => $this->getScheduleColor($schedule->schedule_type)
                ];
            });

        return response()->json($schedules);
    }
    public function getSchedule($id)
    {
        $schedule = Schedule::with('teacher')->findOrFail($id);

        return response()->json([
            'id' => $schedule->id,
            'title' => $schedule->title,
            'time' => $schedule->formatted_time,
            'type' => $schedule->schedule_type,
            'teacher' => $schedule->teacher_full_name,
            'date' => $schedule->date,
            'location' => $schedule->location,
            'description' => $schedule->description,
            'course_name' => $schedule->course_name,
            'class_group' => $schedule->class_group
        ]);
    }
    private function getScheduleColor($type)
{
    $colors = [
        'class' => 'bg-blue-100 text-blue-700 border-l-4 border-blue-500',
        'office_hours' => 'bg-green-100 text-green-700 border-l-4 border-green-500',
        'meeting' => 'bg-red-100 text-red-700 border-l-4 border-red-500',
        'makeup_class' => 'bg-purple-100 text-purple-700 border-l-4 border-purple-500',
        'event_management' => 'bg-yellow-100 text-yellow-700 border-l-4 border-yellow-500',
        'other' => 'bg-gray-100 text-gray-700 border-l-4 border-gray-500'
    ];

    return $colors[$type] ?? 'bg-gray-100 text-gray-700 border-l-4 border-gray-500';
}
}
