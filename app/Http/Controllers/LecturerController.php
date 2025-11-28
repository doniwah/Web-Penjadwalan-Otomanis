<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $lecturer = $user->lecturer;
        
        if (!$lecturer) {
            // Handle case where user is not linked to a lecturer profile
            return redirect()->route('dashboard')->with('error', 'Lecturer profile not found.');
        }

        $schedules = $lecturer->schedules()->with(['course', 'room', 'timeslot'])->get();
        return view('lecturer.dashboard', compact('schedules', 'lecturer'));
    }

    public function updatePreferences(Request $request)
    {
        $request->validate([
            'preferred_days' => 'array',
            'preferred_days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday',
        ]);

        $user = auth()->user();
        $lecturer = $user->lecturer;

        if ($lecturer) {
            $lecturer->update([
                'preferred_days' => $request->preferred_days,
            ]);
        }

        return redirect()->back()->with('success', 'Preferences updated successfully.');
    }
}
