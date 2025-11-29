<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthUITest extends TestCase
{
    public function test_login_page_has_new_theme()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('SiJadu'); // From Guest Layout
        $response->assertSee('Welcome Back'); // New Header
        $response->assertSee('bg-primary'); // Theme class
    }

    public function test_register_page_has_new_theme()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Create Account'); // New Header
    }
}
