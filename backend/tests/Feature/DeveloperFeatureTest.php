<?php

namespace Tests\Feature;

use Tests\HelpersTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeveloperFeatureTest extends TestCase
{
    use RefreshDatabase, HelpersTest;

    public function test_index_returns_developers()
    {
        $levelJunior = $this->createLevel('Junior');
        $this->createDeveloper('John Doe', 'M', '1990-01-01', 'Coding', $levelJunior->id);

        $levelSenior = $this->createLevel('Senior');
        $this->createDeveloper('Jane Doe', 'F', '1990-01-01', 'Coding', $levelSenior->id);

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->getJson('/api/developers');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'gender', 'birth_date', 'hobby', 'created_at', 'updated_at']
                     ]
                 ]);
    }

    public function test_store_creates_developer()
    {
        $level = $this->createLevel('Junior');

        $data = [
            'name' => 'John Doe',
            'level_id' => $level->id,
            'gender' => 'M',
            'birth_date' => '1990-01-01',
            'hobby' => 'Coding',
        ];

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->postJson('/api/developers', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('developers', $data);
    }

    public function test_show_returns_developer()
    {
        $level = $this->createLevel('Junior');
        $developer = $this->createDeveloper('John Doe', 'M', '1990-01-01', 'Coding', $level->id);

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->getJson("/api/developers/{$developer->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'John Doe']);
    }

    public function test_update_modifies_developer()
    {
        $level = $this->createLevel('Junior');
        $developer = $this->createDeveloper('John Doe', 'M', '1990-01-01', 'Coding', $level->id);
        $data = ['name' => 'Jane Doe', 'level_id' => $level->id];

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->putJson("/api/developers/{$developer->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('developers', $data);
    }

    public function test_destroy_deletes_developer()
    {
        $level = $this->createLevel('Junior');
        $developer = $this->createDeveloper('John Doe', 'M', '1990-01-01', 'Coding', $level->id);

        $response = $this->actingAs($this->createUser(), 'sanctum')
                         ->deleteJson("/api/developers/{$developer->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('developers', ['id' => $developer->id]);
    }
}
