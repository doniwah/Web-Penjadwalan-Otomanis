<?php

namespace App\Http\Controllers;

use App\Models\Timeslot;
use Illuminate\Http\Request;

class TimeslotController extends Controller
{
    public function index()
    {
        $timeslots = Timeslot::orderBy('day')->orderBy('start_time')->paginate(10);
        return view('admin.timeslots.index', compact('timeslots'));
    }

    public function create()
    {
        return view('admin.timeslots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Timeslot::create($request->all());

        return redirect()->route('timeslots.index')->with('success', 'Timeslot created successfully.');
    }

    public function edit(Timeslot $timeslot)
    {
        return view('admin.timeslots.edit', compact('timeslot'));
    }

    public function update(Request $request, Timeslot $timeslot)
    {
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $timeslot->update($request->all());

        return redirect()->route('timeslots.index')->with('success', 'Timeslot updated successfully.');
    }

    public function destroy(Timeslot $timeslot)
    {
        $timeslot->delete();
        return redirect()->route('timeslots.index')->with('success', 'Timeslot deleted successfully.');
    }
}
