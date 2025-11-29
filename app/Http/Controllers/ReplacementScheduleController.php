<?php

namespace App\Http\Controllers;

use App\Models\ReplacementSchedule;
use App\Models\Schedule;
use App\Models\Room;
use App\Models\Timeslot;
use Illuminate\Http\Request;

class ReplacementScheduleController extends Controller
{
    // Dosen - List their replacement requests
    public function index()
    {
        $user = auth()->user();
        $lecturer = $user->lecturer;

        $replacements = ReplacementSchedule::with(['schedule.course', 'originalTimeslot', 'replacementTimeslot', 'originalRoom', 'replacementRoom'])
            ->where('lecturer_id', $lecturer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dosen.replacement-schedule', compact('replacements'));
    }

    // Dosen - Show create form
    public function create()
    {
        $user = auth()->user();
        $lecturer = $user->lecturer;

        // Get lecturer's schedules
        $schedules = Schedule::with(['course', 'timeslot', 'room'])
            ->where(function($query) use ($lecturer) {
                $query->where('lecturer_id_1', $lecturer->id)
                      ->orWhere('lecturer_id_2', $lecturer->id);
            })
            ->get();

        $rooms = Room::all();
        $timeslots = Timeslot::all();

        return view('dosen.replacement-schedule-create', compact('schedules', 'rooms', 'timeslots'));
    }

    // Dosen - Store replacement request
    public function store(Request $request)
    {
        $user = auth()->user();
        $lecturer = $user->lecturer;

        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'original_date' => 'required|date',
            'replacement_date' => 'required|date|after:today',
            'original_timeslot_id' => 'required|exists:timeslots,id',
            'replacement_timeslot_id' => 'required|exists:timeslots,id',
            'original_room_id' => 'required|exists:rooms,id',
            'replacement_room_id' => 'required|exists:rooms,id',
            'reason' => 'required|string|max:1000',
        ]);

        $validated['lecturer_id'] = $lecturer->id;
        $validated['status'] = 'pending';

        ReplacementSchedule::create($validated);

        return redirect()->route('dosen.replacement-schedule')->with('success', 'Pengajuan jadwal pengganti berhasil dikirim!');
    }

    // Admin - List all replacement requests
    public function adminIndex()
    {
        $replacements = ReplacementSchedule::with(['schedule.course', 'lecturer.user', 'originalTimeslot', 'replacementTimeslot', 'originalRoom', 'replacementRoom'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.replacement-schedules.index', compact('replacements'));
    }

    // Admin - Approve replacement
    public function approve(Request $request, ReplacementSchedule $replacement)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $replacement->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Pengajuan jadwal pengganti disetujui!');
    }

    // Admin - Reject replacement
    public function reject(Request $request, ReplacementSchedule $replacement)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $replacement->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Pengajuan jadwal pengganti ditolak!');
    }
}
