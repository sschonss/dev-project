<?php

namespace Tests\Unit;

use App\Domains\Level\Services\LevelService;
use Tests\HelpersTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LevelUnitTest extends TestCase
{
    use RefreshDatabase, HelpersTest;

    public function test_create_level()
    {
        $level = $this->createLevel('Junior');

        $this->assertDatabaseHas('levels', ['level' => 'Junior']);
    }

    public function test_update_level()
    {
        $level = $this->createLevel('Junior');
        $level->update(['level' => 'Senior']);

        $this->assertDatabaseHas('levels', ['level' => 'Senior']);
    }

    public function test_delete_level()
    {
        $level = $this->createLevel('Junior');
        $level->delete();

        $this->assertSoftDeleted('levels', ['id' => $level->id]);
    }

    public function test_create_level_with_service()
    {
        $levelService = new LevelService();
        $level = $levelService->createLevel(['level' => 'Junior']);

        $this->assertDatabaseHas('levels', ['level' => 'Junior']);
    }

    public function test_update_level_with_service()
    {
        $level = $this->createLevel('Junior');
        $levelService = new LevelService();
        $levelService->updateLevel(['level' => 'Senior'], $level->id);

        $this->assertDatabaseHas('levels', ['level' => 'Senior']);
    }

    public function test_delete_level_with_service()
    {
        $level = $this->createLevel('Junior');
        $levelService = new LevelService();
        $levelService->deleteLevel($level->id);

        $this->assertSoftDeleted('levels', ['id' => $level->id]);
    }

    public function test_get_levels_with_service()
    {
        $level = $this->createLevel('Junior');
        $levelService = new LevelService();
        $levels = $levelService->getLevels();

        $this->assertCount(1, $levels);
    }

    public function test_get_level_with_service()
    {
        $level = $this->createLevel('Junior');
        $levelService = new LevelService();
        $foundLevel = $levelService->getLevel($level->id);

        $this->assertEquals($level->id, $foundLevel->id);
    }

    public function test_get_level_not_found_with_service()
    {
        $levelService = new LevelService();
        $foundLevel = $levelService->getLevel(1);

        $this->assertNull($foundLevel);
    }

    public function test_update_level_not_found_with_service()
    {
        $levelService = new LevelService();
        $level = $levelService->updateLevel(['level' => 'Senior'], 1);

        $this->assertNull($level);
    }

    public function test_delete_level_not_found_with_service()
    {
        $levelService = new LevelService();
        $level = $levelService->deleteLevel(1);

        $this->assertNull($level);
    }

    public function test_delete_level_with_invalid_id()
    {
        $levelService = new LevelService();
        $result = $levelService->deleteLevel(999);

        $this->assertNull($result);
    }
}
