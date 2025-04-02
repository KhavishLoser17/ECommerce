<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Schedule;

class FacultyController extends Controller
{
    public function faculty(){
        return view('admin.faculty-attendance');
    }
    public function index()
{
    $teachers = Teacher::select('id', 'title', 'first_name', 'last_name')
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    return view('admin.faculty-attendance', compact('teachers'));
}
        public function store(Request $request)
        {
            $validated = $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'location' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:7'
            ]);

            $schedule = Schedule::create($validated);

            return response()->json([
                'success' => true,
                'schedule' => $schedule
            ]);
        }

        public function getTeacherSchedules(Teacher $teacher, Request $request)
        {
            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date'
            ]);

            $schedules = $teacher->schedules()
                ->whereBetween('start_time', [$request->start, $request->end])
                ->get()
                ->map(function($schedule) {
                    return [
                        'id' => $schedule->id,
                        'title' => $schedule->title,
                        'start' => $schedule->start_time,
                        'end' => $schedule->end_time,
                        'color' => $schedule->color,
                        'extendedProps' => [
                            'description' => $schedule->description,
                            'location' => $schedule->location,
                            'teacher_id' => $schedule->teacher_id
                        ]
                    ];
                });

            return response()->json($schedules);
        }
}
