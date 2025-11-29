<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_loads()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SiJadu');
        $response->assertSee('Jadwal Kuliah Otomatis');
        $response->assertSee('Fitur Unggulan');
    }
}
