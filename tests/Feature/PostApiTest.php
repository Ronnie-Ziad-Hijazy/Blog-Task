<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostApiTest extends TestCase
{
    // use RefreshDatabase;

    public function test_can_list_posts()
    {
        Post::factory()->count(3)->create();
        $response = $this->getJson('/api/posts');
        $response->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_can_create_post()
    {
        $category = Category::find(rand(1,10));
        $response = $this->postJson('/api/posts', [
            'title' => 'Sample Post',
            'content' => 'Content here',
            'author' => 'Ronnie',
            'category_id' => $category->id,
        ]);
        
        $response->assertStatus(201)
        ->assertJsonPath('success', true);

        $this->assertDatabaseHas('posts', ['title' => 'Sample Post']);
    }

    public function test_can_show_post()
    {
        $post = Post::factory()->create();
        $response = $this->getJson("/api/posts/{$post->id}");
        $response->assertStatus(200)->assertJsonPath('status', true);
    }

    public function test_can_update_post()
    {
        $post = Post::factory()->create();
        $response = $this->putJson("/api/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => $post->content,
            'author' => $post->author,
            'category_id' => $post->category_id,
        ]);

        $response->assertStatus(200)->assertJsonPath('success', true);
        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    public function test_can_delete_post()
    {
        $post = Post::factory()->create();
        $response = $this->deleteJson("/api/posts/{$post->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
