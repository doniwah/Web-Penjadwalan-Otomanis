<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        // Dosen Dashboard
        $user = auth()->user();
        $lecturer = $user->lecturer;
        
        // Get today's schedule for this lecturer
        $todaySchedules = collect();
        
        if ($lecturer) {
            $today = now()->format('l'); // Get day name
            
            $todaySchedules = Schedule::with(['course', 'room', 'timeslot'])
                ->where(function($query) use ($lecturer) {
                    $query->where('lecturer_id_1', $lecturer->id)
                          ->orWhere('lecturer_id_2', $lecturer->id);
                })
                ->whereHas('timeslot', function($query) use ($today) {
                    $query->where('day', $today);
                })
                ->orderBy('timeslot_id')
                ->get();
        }
        
        return view('dosen.dashboard', compact('lecturer', 'todaySchedules'));
    }

    public function schedule()
    {
        // View all schedules for this lecturer
        $user = auth()->user();
        $lecturer = $user->lecturer;
        
        $schedules = collect();
        
        if ($lecturer) {
            $schedules = Schedule::with(['course', 'room', 'timeslot'])
                ->where(function($query) use ($lecturer) {
                    $query->where('lecturer_id_1', $lecturer->id)
                          ->orWhere('lecturer_id_2', $lecturer->id);
                })
                ->orderBy('timeslot_id')
                ->get();
        }
        
        return view('dosen.schedule', compact('schedules'));
    }

    public function replacementSchedule()
    {
        // Replacement schedule requests
        return view('dosen.replacement-schedule');
    }

    public function notifications()
    {
        // Notification settings
        return view('dosen.notifications');
    }
}
