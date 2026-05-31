<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_root_redirects_to_admin_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_public_content_api_returns_content_shape(): void
    {
        $this->seed();

        $response = $this->getJson('/api/content');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'categories' => [['id', 'title', 'description']],
                'categoryContent',
                'mediaItems' => [['id', 'type', 'size', 'categoryId', 'image', 'title']],
            ]);
    }
}
