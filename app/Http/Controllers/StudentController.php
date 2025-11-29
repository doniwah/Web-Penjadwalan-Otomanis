<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Student Dashboard
        return view('student.dashboard');
    }

    public function schedule()
    {
        // View student's schedule
        // TODO: Filter by student's enrolled courses
        $schedules = Schedule::with(['course', 'lecturer', 'room', 'timeslot'])->get();
        return view('student.schedule', compact('schedules'));
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
