<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    public function homepage_should_return_success_status()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
