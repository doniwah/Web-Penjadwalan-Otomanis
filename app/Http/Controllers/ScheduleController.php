<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Services\GeneticAlgorithmService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function showGenerate()
    {
        $assignmentsCount = \App\Models\TeachingAssignment::count();
        $roomsCount = \App\Models\Room::count();
        $timeslotsCount = \App\Models\Timeslot::count();
        $lecturersCount = \App\Models\Lecturer::count();

        return view('admin.schedule.generate', compact('assignmentsCount', 'roomsCount', 'timeslotsCount', 'lecturersCount'));
    }

    public function runGeneration(Request $request, GeneticAlgorithmService $ga)
    {
        $request->validate([
            'population_size' => 'required|integer|min:10|max:200',
            'generations' => 'required|integer|min:10|max:500',
            'mutation_rate' => 'required|numeric|min:0|max:1',
            'crossover_rate' => 'required|numeric|min:0|max:1',
        ]);

        // Configure GA with user parameters
        $ga = new GeneticAlgorithmService(
            $request->population_size,
            $request->mutation_rate,
            $request->crossover_rate,
            2 // elitism count
        );

        // Run GA
        $bestSchedule = $ga->run($request->generations);

        if (empty($bestSchedule)) {
            return redirect()->back()->with('error', 'Failed to generate schedule. Please ensure all data is configured properly.');
        }

        // Save to Database
        Schedule::truncate(); // Clear old schedule

        foreach ($bestSchedule as $gene) {
            Schedule::create([
                'course_id' => $gene['course_id'],
                'lecturer_id_1' => $gene['lecturer_id_1'],
                'lecturer_id_2' => $gene['lecturer_id_2'] ?? null,
                'room_id' => $gene['room_id'],
                'timeslot_id' => $gene['timeslot_id'],
                'class_name' => $gene['class_name'],
            ]);
        }

        $fitness = $ga->calculateFitness($bestSchedule);

        return redirect()->route('schedules.index')->with('success', 'Schedule generated successfully! Fitness score: ' . number_format($fitness, 4));
    }

    public function generate(GeneticAlgorithmService $ga)
    {
        // Run GA
        $bestSchedule = $ga->run();

        // Save to Database
        Schedule::truncate(); // Clear old schedule

        foreach ($bestSchedule as $gene) {
            Schedule::create([
                'course_id' => $gene['course_id'],
                'lecturer_id_1' => $gene['lecturer_id_1'],
                'lecturer_id_2' => $gene['lecturer_id_2'] ?? null,
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
