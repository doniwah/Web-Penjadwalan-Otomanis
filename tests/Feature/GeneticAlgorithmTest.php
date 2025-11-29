<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeneticAlgorithmTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_ga_generates_schedule()
    {
        // Seed data
        $course = \App\Models\Course::create([
            'code' => 'IF101',
            'name' => 'Intro to CS',
            'sks' => 3,
            'semester' => 1,
            'is_lab' => false,
        ]);

        $user = \App\Models\User::factory()->create();
        $lecturer = \App\Models\Lecturer::create([
            'user_id' => $user->id,
            'nip' => '123456',
            'max_sks' => 12,
        ]);

        $room = \App\Models\Room::create([
            'name' => 'Room 101',
            'capacity' => 50,
            'type' => 'theory',
        ]);

        $timeslot = \App\Models\Timeslot::create([
            'day' => 'Monday',
            'start_time' => '08:00',
            'end_time' => '10:00',
        ]);

        \App\Models\TeachingAssignment::create([
            'course_id' => $course->id,
            'lecturer_id' => $lecturer->id,
            'class_name' => 'A',
            'students_count' => 30,
        ]);

        // Run GA
        $ga = new \App\Services\GeneticAlgorithmService();
        $schedule = $ga->run(10); // 10 generations

        $this->assertNotEmpty($schedule);
        $this->assertEquals($course->id, $schedule[0]['course_id']);
        $this->assertEquals($lecturer->id, $schedule[0]['lecturer_id']);
        $this->assertEquals($room->id, $schedule[0]['room_id']);
        $this->assertEquals($timeslot->id, $schedule[0]['timeslot_id']);
    }
}
