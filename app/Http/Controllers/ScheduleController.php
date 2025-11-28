<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Services\GeneticAlgorithmService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function generate(GeneticAlgorithmService $ga)
    {
        // Run GA
        $bestSchedule = $ga->run();

        // Save to Database
        Schedule::truncate(); // Clear old schedule

        foreach ($bestSchedule as $gene) {
            Schedule::create([
                'course_id' => $gene['course_id'],
                'lecturer_id' => $gene['lecturer_id'],
                'room_id' => $gene['room_id'],
                'timeslot_id' => $gene['timeslot_id'],
                'class_name' => $gene['class_name'],
            ]);
        }

        return response()->json([
            'message' => 'Schedule generated successfully',
            'data' => $bestSchedule,
            'fitness' => $ga->calculateFitness($bestSchedule)
        ]);
    }

    public function index()
    {
        $schedules = Schedule::with(['course', 'lecturer', 'room', 'timeslot'])->get();
        $timeslots = \App\Models\Timeslot::orderBy('start_time')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        return view('schedules.index', compact('schedules', 'timeslots', 'days'));
    }

    public function publish()
    {
        // In a real app, use a Job for this
        $users = \App\Models\User::all();
        \Illuminate\Support\Facades\Notification::send($users, new \App\Notifications\SchedulePublished());

        return redirect()->back()->with('success', 'Schedule published and notifications sent.');
    }
}
