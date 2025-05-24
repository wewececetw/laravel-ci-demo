<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 測試首頁是否可以正常訪問
     */
    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * 測試資料庫連接是否正常
     */
    public function test_database_connection(): void
    {
        $this->assertDatabaseHas('migrations', [
            'migration' => '0001_01_01_000000_create_users_table',
        ]);
    }
}
