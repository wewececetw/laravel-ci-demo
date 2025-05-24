<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Article $article;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->article = Article::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_unauthorized_user_cannot_access_protected_routes()
    {
        $response = $this->get('/articles');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $response = $this->get('/articles/trash');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_get_articles()
    {
        $this->actingAs($this->user);

        $response = $this->get('/articles');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_article()
    {
        $this->actingAs($this->user);

        $articleData = [
            'title' => 'Test Article',
            'content' => 'This is a test article content',
        ];

        $response = $this->post('/articles', $articleData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('articles', $articleData);
    }

    public function test_authenticated_user_can_update_their_article()
    {
        $this->actingAs($this->user);

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ];

        $response = $this->put("/articles/{$this->article->id}", $updateData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('articles', $updateData);
    }

    public function test_authenticated_user_can_delete_their_article()
    {
        $this->actingAs($this->user);

        $response = $this->delete("/articles/{$this->article->id}");

        $response->assertStatus(302);
        $this->assertSoftDeleted('articles', ['id' => $this->article->id]);
    }

    public function test_authenticated_user_can_view_trash()
    {
        $this->actingAs($this->user);
        $this->article->delete();

        $response = $this->get('/articles/trash');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_restore_article()
    {
        $this->actingAs($this->user);
        $this->article->delete();

        $response = $this->post("/articles/{$this->article->id}/restore");

        $response->assertStatus(302);
        $this->assertDatabaseHas('articles', ['id' => $this->article->id]);
        $this->assertNull($this->article->fresh()->deleted_at);
    }

    public function test_authenticated_user_can_force_delete_article()
    {
        $this->actingAs($this->user);
        $this->article->delete();

        $response = $this->delete("/articles/{$this->article->id}/force");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('articles', ['id' => $this->article->id]);
    }
}
