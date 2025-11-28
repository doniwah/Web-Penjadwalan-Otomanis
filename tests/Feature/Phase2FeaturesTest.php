<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lecturer;
use App\Notifications\SchedulePublished;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class Phase2FeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_lecturer_can_update_preferences()
    {
        $user = User::factory()->create(['role' => 'dosen']);
        $lecturer = Lecturer::create(['user_id' => $user->id, 'nip' => '12345', 'max_sks' => 12]);

        $response = $this->actingAs($user)->post('/lecturer/preferences', [
            'preferred_days' => ['Monday', 'Wednesday'],
        ]);

        $response->assertRedirect();
        $this->assertEquals(['Monday', 'Wednesday'], $lecturer->fresh()->preferred_days);
    }

    public function test_admin_can_publish_schedule()
    {
        Notification::fake();

        $user = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($user)->post('/publish-schedule');

        $response->assertRedirect();
        
        Notification::assertSentTo(
            User::all(),
            SchedulePublished::class
        );
    }
}
