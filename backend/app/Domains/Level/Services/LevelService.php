<?php

namespace App\Domains\Level\Services;

use App\Domains\Level\Models\Level;
use App\Domains\Level\Repositories\LevelRepository;
use Illuminate\Database\Eloquent\Collection;

class LevelService
{
    private LevelRepository $levelRepository;

    public function __construct()
    {
        $this->levelRepository = new LevelRepository();
    }

    public function createLevel(array $data): Level
    {
        $data['level'] = ucfirst($data['level']);
        return $this->levelRepository->save($data);
    }

    public function getLevels(): Collection
    {
        return $this->levelRepository->all();
    }

    public function getLevel(int $id): ?Level
    {
        return $this->levelRepository->find($id);
    }

    public function updateLevel(array $data, int $id): ?Level
    {
        $data['level'] = ucfirst($data['level']);
        $level = $this->levelRepository->find($id);
        if (!$level) {
            return $level;
        }
        return $this->levelRepository->update($data, $level);
    }

    public function deleteLevel(int $id): ?Level
    {
        $level = $this->levelRepository->find($id);

        if (!$level) {
            return null;
        }
        
        if ($level->developers->isNotEmpty()) {
            return null;
        }

        return $this->levelRepository->delete($level);
    }
}
