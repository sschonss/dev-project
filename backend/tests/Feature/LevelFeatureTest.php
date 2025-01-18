<?php

namespace Tests\Feature;

use Tests\HelpersTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LevelFeatureTest extends TestCase
{
    use RefreshDatabase, HelpersTest;

    public function test_index_returns_levels()
    {
        $this->createLevel('Junior');
        $this->createLevel('Senior');

        $response = $this->actingAs($user = $this->createUser(), 'sanctum')
                         ->getJson('/api/levels');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'level', 'created_at', 'updated_at']
                     ]
                 ]);
    }

    public function test_store_creates_level()
    {
        $data = ['level' => 'Junior'];

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->postJson('/api/levels', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('levels', $data);
    }

    public function test_show_returns_level()
    {
        $level = $this->createLevel('Junior');

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->getJson("/api/levels/{$level->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['level' => $level->level]);
    }

    public function test_update_modifies_level()
    {
        $level = $this->createLevel('Junior');
        $data = ['level' => 'Senior'];

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->putJson("/api/levels/{$level->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('levels', $data);
    }

    public function test_destroy_deletes_level()
    {
        $level = $this->createLevel('Junior');

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->deleteJson("/api/levels/{$level->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('levels', ['id' => $level->id]);
    }
}
