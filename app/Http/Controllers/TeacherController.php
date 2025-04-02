<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class TeacherController extends Controller
{
    public function teacher(){
        return view('admin.teacher');
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i|after:working_hours_start',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'nullable|string|max:20',
            'course' => 'required|string|max:255',
            'classes' => 'nullable|integer|min:0',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        

        Teacher::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'title' => $request->title,
            'working_hours_start' => $request->working_hours_start,
            'working_hours_end' => $request->working_hours_end,
            'email' => $request->email,
            'phone' => $request->phone,
            'course' => $request->course,
            'classes' => $request->classes,
            'profile_image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Teacher added successfully');
    }

    public function show()
    {
        $teachers = Teacher::all()->map(function ($teacher) {
            $start = \Carbon\Carbon::createFromFormat('H:i:s', $teacher->working_hours_start);
            $end = \Carbon\Carbon::createFromFormat('H:i:s', $teacher->working_hours_end);
            $hours = $start->diffInHours($end);
            $teacher->status = $hours >= 8 ? 'Full-Time' : 'Part-Time';
            return $teacher;
        });

        return view('admin.teacher', compact('teachers'));
    }


        public function edit($id)
        {
            $teacher = Teacher::findOrFail($id);
            return response()->json(['teacher' => $teacher]);
        }

        public function update(Request $request, $id)
        {
            $teacher = Teacher::findOrFail($id);

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
                'phone' => 'nullable|numeric',
                'working_hours_start' => 'required|date_format:H:i',
                'working_hours_end' => 'required|date_format:H:i',
                'course' => 'required|string|max:255',
                'classes' => 'nullable|integer|min:0|max:10',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $teacher->first_name = $request->first_name;
            $teacher->last_name = $request->last_name;
            $teacher->email = $request->email;
            $teacher->phone = $request->phone;
            $teacher->working_hours_start = $request->working_hours_start;
            $teacher->working_hours_end = $request->working_hours_end;
            $teacher->course = $request->course;
            $teacher->classes = $request->classes;

            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $teacher->profile_image = $imagePath;
            }

            $teacher->save();

            return redirect()->route('admin.teacher')->with('success', 'Teacher updated successfully!');
        }
        public function destroy($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json(['success' => false, 'message' => 'Teacher not found'], 404);
        }

        $teacher->delete();

        return response()->json(['success' => true, 'message' => 'Teacher deleted successfully']);
    }

        public function fetch(Teacher $teacher)
    {
        return response()->json([
            'id' => $teacher->id,
            'title' => $teacher->title,
            'first_name' => $teacher->first_name,
            'last_name' => $teacher->last_name,
            'course' => $teacher->course,
            'working_hours_start' => $teacher->working_hours_start,
            'working_hours_end' => $teacher->working_hours_end
        ]);
    }

}
