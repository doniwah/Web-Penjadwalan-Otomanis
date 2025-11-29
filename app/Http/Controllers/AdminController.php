<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $lecturersCount = Lecturer::count();
        $studentsCount = Student::count();
        $coursesCount = Course::count();
        $roomsCount = Room::count();
        $assignmentsCount = \App\Models\TeachingAssignment::count();

        return view('admin.dashboard', compact('lecturersCount', 'studentsCount', 'coursesCount', 'roomsCount', 'assignmentsCount'));
    }
}
