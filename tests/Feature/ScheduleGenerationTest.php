<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Timeslot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_schedule_generation()
    {
        // Seed data
        $this->seed();

        // Call the endpoint
        $response = $this->get('/generate-schedule');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data',
            'fitness'
        ]);

        // Verify database
        $this->assertDatabaseCount('schedules', Course::count());
    }
}
