<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('user')->paginate(10);
        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        return view('admin.lecturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|unique:lecturers,nip',
            'max_sks' => 'nullable|integer|min:1',
        ]);

        // Create User first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        // Create Lecturer
        Lecturer::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'max_sks' => $request->max_sks ?? 12,
            'preferred_days' => [],
        ]);

        return redirect()->route('lecturers.index')->with('success', 'Lecturer created successfully.');
    }

    public function edit(Lecturer $lecturer)
    {
        return view('admin.lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $lecturer->user_id,
            'nip' => 'required|string|unique:lecturers,nip,' . $lecturer->id,
            'max_sks' => 'nullable|integer|min:1',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update User
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $lecturer->user->update($userData);

        // Update Lecturer
        $lecturer->update([
            'nip' => $request->nip,
            'max_sks' => $request->max_sks ?? 12,
        ]);

        return redirect()->route('lecturers.index')->with('success', 'Lecturer updated successfully.');
    }

    public function destroy(Lecturer $lecturer)
    {
        $user = $lecturer->user;
        $lecturer->delete();
        $user->delete();
        
        return redirect()->route('lecturers.index')->with('success', 'Lecturer deleted successfully.');
    }
}
