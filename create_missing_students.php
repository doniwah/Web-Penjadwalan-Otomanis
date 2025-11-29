<?php

// Script to create student records for mahasiswa users who don't have one yet

use App\Models\User;
use App\Models\Student;

$users = User::where('role', 'mahasiswa')->whereDoesntHave('student')->get();

foreach ($users as $user) {
    Student::create([
        'user_id' => $user->id,
        'nim' => 'STD' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
    ]);
    echo "Created student record for user: {$user->name} (ID: {$user->id})\n";
}

echo "\nTotal students created: " . $users->count() . "\n";
