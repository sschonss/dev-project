<?php

namespace Tests\Unit;

use App\Domains\Developer\Models\Developer;
use App\Domains\Level\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeveloperUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_developer()
    {
        $level = Level::create(['level' => 'Junior']);
        $developer = Developer::create([
            'name' => 'John Doe',
            'level_id' => $level->id,
            'gender' => 'M',
            'birth_date' => '1990-01-01',
            'hobby' => 'Coding',
        ]);

        $this->assertDatabaseHas('developers', ['name' => 'John Doe']);
    }

    public function test_update_developer()
    {
        $level = Level::create(['level' => 'Junior']);
        $developer = Developer::create([
            'name' => 'John Doe',
            'level_id' => $level->id,
            'gender' => 'M',
            'birth_date' => '1990-01-01',
            'hobby' => 'Coding',
        ]);

        $developer->update(['name' => 'Jane Doe']);

        $this->assertDatabaseHas('developers', ['name' => 'Jane Doe']);
    }

    public function test_delete_developer()
    {
        $level = Level::create(['level' => 'Junior']);
        $developer = Developer::create([
            'name' => 'John Doe',
            'level_id' => $level->id,
            'gender' => 'M',
            'birth_date' => '1990-01-01',
            'hobby' => 'Coding',
        ]);

        $developer->delete();

        $this->assertSoftDeleted('developers', ['id' => $developer->id]);
    }

    public function test_developer_belongs_to_level()
    {
        $level = Level::create(['level' => 'Junior']);
        $developer = Developer::create([
            'name' => 'John Doe',
            'level_id' => $level->id,
            'gender' => 'M',
            'birth_date' => '1990-01-01',
            'hobby' => 'Coding',
        ]);

        $this->assertEquals('Junior', $developer->level->level);
    }

    public function test_create_developer_with_invalid_data()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Developer::create([
            'name' => null,
            'level_id' => null,
            'gender' => 'M',
            'birth_date' => '1990-01-01',
            'hobby' => 'Coding',
        ]);
    }

    public function test_update_developer_with_invalid_data()
    {
        $level = Level::create(['level' => 'Junior']);
        $developer = Developer::create([
            'name' => 'John Doe',
            'level_id' => $level->id,
            'gender' => 'M',
            'birth_date' => '1990-01-01',
            'hobby' => 'Coding',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        $developer->update(['name' => null]);
    }

    public function test_find_developer_by_id()
    {
        $level = Level::create(['level' => 'Junior']);
        $developer = Developer::create([
            'name' => 'John Doe',
            'level_id' => $level->id,
            'gender' => 'M',
            'birth_date' => '1990-01-01',
            'hobby' => 'Coding',
        ]);

        $foundDeveloper = Developer::find($developer->id);

        $this->assertNotNull($foundDeveloper);
        $this->assertEquals($developer->id, $foundDeveloper->id);
    }

    public function test_find_developer_by_invalid_id()
    {
        $foundDeveloper = Developer::find(999);

        $this->assertNull($foundDeveloper);
    }
}
