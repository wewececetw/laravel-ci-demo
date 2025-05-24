<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_name()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
        ]);

        $this->assertEquals('Test User', $user->name);
    }

    public function test_user_has_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('test@example.com', $user->email);
    }

    public function test_user_can_have_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $this->assertTrue(password_verify('password123', $user->password));
    }

    public function test_user_has_articles_relationship()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->articles);
    }
}
