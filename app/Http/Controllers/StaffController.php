<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function staff(){
        return view('admin.staff');
    }
    // In your controller
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'required|string|max:20',
            'working_hours' => 'nullable|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'role' => 'required|string|max:255',
            'status' => 'required|in:Full-Time,Part-Time,Contractor',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload and store only the relative path
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create the staff member
        $staff = Staff::create($validated);
        \Illuminate\Support\Facades\Storage::url($staff->profile_picture);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Staff member added successfully!',
                'staff' => $staff
            ]);
        }

        return redirect()->back()->with('success', 'Staff member added successfully!');
    }

        public function show()
    {
        $staffs = Staff::orderBy('name')->get();
        return view('admin.staff', compact('staffs'));
    }
    // Add this method to your StaffController
        public function edit($id)
        {
            $staff = Staff::findOrFail($id);
            return response()->json($staff);
        }

        // Update method (already exists)
        public function update(Request $request, $id)
        {
            $staff = Staff::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'email' => 'required|email|unique:staff,email,'.$id,
                'phone' => 'required|string|max:20',
                'working_hours' => 'nullable|string|max:255',
                'department' => 'required|string|max:255',
                'role' => 'required|string|max:255',
                'status' => 'required|in:Full-Time,Part-Time,Contractor',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('profile_picture')) {
                // Delete old image if exists
                if ($staff->profile_pictures) {
                    Storage::delete('public/profile_pictures/'.$staff->profile_pictures);
                }
                $validated['profile_pictures'] = $request->file('profile_picture')->store('profile_pictures', 'public');
            }

            $staff->update($validated);

            return response()->json(['success' => true, 'message' => 'Staff updated successfully']);
        }
        public function destroy($id)
        {
            $staff = Staff::findOrFail($id);

            // Delete profile picture if exists
            if ($staff->profile_pictures) {
                Storage::delete('public/profile_pictures/'.$staff->profile_pictures);
            }

            $staff->delete();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Staff member deleted successfully']);
            }

            return redirect()->route('admin.staff')
                ->with('success', 'Staff member deleted successfully');
        }
}
