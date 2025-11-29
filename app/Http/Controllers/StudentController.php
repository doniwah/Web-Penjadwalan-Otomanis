<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;
        
        // Get today's schedule if student has class info
        $todaySchedules = collect();
        $totalCourses = 0;
        
        if ($student && $student->class_name && $student->prodi && $student->semester) {
            $today = now()->format('l'); // Get day name (Monday, Tuesday, etc.)
            
            // Get schedules that match student's class
            // Note: Schedules table only has class_name, not prodi/semester
            // So we match by class_name and filter by day
            $todaySchedules = \App\Models\Schedule::with(['course', 'room', 'timeslot', 'lecturer1.user', 'lecturer2.user'])
                ->where('class_name', $student->class_name)
                ->whereHas('timeslot', function($query) use ($today) {
                    $query->where('day', $today);
                })
                ->orderBy('timeslot_id')
                ->get();
            
            // Get total courses for this student based on teaching assignments
            $totalCourses = \App\Models\TeachingAssignment::where('class_name', $student->class_name)
                ->where('prodi', $student->prodi)
                ->where('semester', $student->semester)
                ->count();
        }
        
        return view('student.dashboard', compact('student', 'todaySchedules', 'totalCourses'));
    }

    public function schedule()
    {
        $user = auth()->user();
        $student = $user->student;
        
        // Get all schedules for student's class, grouped by day
        $schedules = collect();
        $timeslots = collect();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        if ($student && $student->class_name) {
            // Get schedules that match student's class
            $schedules = Schedule::with(['course', 'room', 'timeslot', 'lecturer1.user', 'lecturer2.user'])
                ->where('class_name', $student->class_name)
                ->orderBy('timeslot_id')
                ->get();
            
            // Get all timeslots for table structure
            $timeslots = \App\Models\Timeslot::orderBy('start_time')->get();
        }
        
        return view('student.schedule', compact('schedules', 'student', 'timeslots', 'days'));
    }

    public function replacementSchedule()
    {
        // View replacement schedules
        // TODO: Implement replacement schedule logic
        return view('student.replacement-schedule');
    }

    public function notifications()
    {
        // Notification settings
        return view('student.notifications');
    }
}
