<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Timeslot;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users & Lecturers
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Lecturer $i",
                'email' => "lecturer$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);
            Lecturer::create([
                'user_id' => $user->id,
                'nip' => "NIP$i",
                'max_sks' => 12,
            ]);
        }

        // Rooms
        Room::create(['name' => 'R101', 'capacity' => 30, 'type' => 'theory']);
        Room::create(['name' => 'R102', 'capacity' => 30, 'type' => 'theory']);
        Room::create(['name' => 'LAB1', 'capacity' => 20, 'type' => 'lab']);

        // Courses
        Course::create(['code' => 'CS101', 'name' => 'Intro to CS', 'sks' => 3, 'semester' => 1]);
        Course::create(['code' => 'CS102', 'name' => 'Programming', 'sks' => 4, 'semester' => 1, 'is_lab' => true]);
        Course::create(['code' => 'CS201', 'name' => 'Data Structures', 'sks' => 3, 'semester' => 3]);
        Course::create(['code' => 'CS202', 'name' => 'Algorithms', 'sks' => 3, 'semester' => 3]);

        // Timeslots (Mon-Fri, 08:00-16:00, 2 hour slots)
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $times = [
            ['08:00', '10:00'],
            ['10:00', '12:00'],
            ['13:00', '15:00'],
            ['15:00', '17:00'],
        ];

        foreach ($days as $day) {
            foreach ($times as $time) {
                Timeslot::create([
                    'day' => $day,
                    'start_time' => $time[0],
                    'end_time' => $time[1],
                ]);
            }
        }
    }
}
