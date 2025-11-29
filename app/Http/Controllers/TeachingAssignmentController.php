<?php

namespace App\Http\Controllers;

use App\Models\TeachingAssignment;
use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class TeachingAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = TeachingAssignment::with(['course', 'lecturer1.user', 'lecturer2.user'])->paginate(10);
        return view('admin.assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $lecturers = Lecturer::with('user')->get();
        return view('admin.assignments.create', compact('courses', 'lecturers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lecturer_id_1' => 'required|exists:lecturers,id',
            'lecturer_id_2' => 'nullable|exists:lecturers,id',
            'class_name' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        TeachingAssignment::create($request->all());

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeachingAssignment $teachingAssignment)
    {
        $courses = Course::all();
        $lecturers = Lecturer::with('user')->get();
        return view('admin.assignments.edit', compact('teachingAssignment', 'courses', 'lecturers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeachingAssignment $teachingAssignment)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lecturer_id_1' => 'required|exists:lecturers,id',
            'lecturer_id_2' => 'nullable|exists:lecturers,id',
            'class_name' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $teachingAssignment->update($request->all());

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeachingAssignment $teachingAssignment)
    {
        $teachingAssignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}
