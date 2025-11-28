<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_access()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_lecturer_dashboard_access()
    {
        $user = User::factory()->create(['role' => 'dosen']);
        Lecturer::create(['user_id' => $user->id, 'nip' => '12345', 'max_sks' => 12]);
        
        $response = $this->actingAs($user)->get('/lecturer/dashboard');
        $response->assertStatus(200);
    }

    public function test_student_dashboard_access()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $response = $this->actingAs($user)->get('/student/dashboard');
        $response->assertStatus(200);
    }
}
