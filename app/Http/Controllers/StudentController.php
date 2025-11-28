<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Ideally filter by student's enrolled courses. 
        // For now, showing all schedules.
        $schedules = Schedule::with(['course', 'lecturer', 'room', 'timeslot'])->get();
        return view('student.dashboard', compact('schedules'));
    }
}
