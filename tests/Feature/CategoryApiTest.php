<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    
    public function test_can_list_categories()
    {
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_can_create_category()
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Tech'. rand(1,2000),
            'description' => 'Technology posts'
        ]);

        $response->assertStatus(201)->assertJsonPath('success', true);
        $this->assertDatabaseHas('categories', ['name' => 'Tech']);
    }

    public function test_can_show_category()
    {
        $category = Category::factory()->create();
        $response = $this->getJson("/api/categories/{$category->id}");
        $response->assertStatus(200)->assertJsonPath('success', true);
    }

    public function test_can_update_category()
    {
        $category = Category::factory()->create();
        $categoryName = $category->name . ' ' . rand(1,200000);
        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => $categoryName,
            'description' => 'Updated description'
        ]);

        $response->assertStatus(200)->assertJsonPath('success', true);
        $this->assertDatabaseHas('categories', ['name' => $categoryName]);
    }

    public function test_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");
    
        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
