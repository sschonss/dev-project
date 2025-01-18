<?php

namespace App\Domains\Level\Repositories;

use App\Domains\Level\Models\Level;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LevelRepository
{
    protected Level $level;
    public function __construct()
    {
        $this->level = new Level();
    }

    public function save(array $data): Level
    {
        $level = $this->level;
        $level->level = $data['level'];

        DB::transaction(function () use ($level) {
            $level->save();
        });

        return $level;
    }

    public function all(): Collection
    {
        return $this->level->all();
    }

    public function find(int $id): Level|null
    {
        return $this->level->newQuery()->find($id);
    }

    public function update(array $data, Level $level): Level
    {
        $level->level = $data['level'];

        DB::transaction(function () use ($level) {
            $level->save();
        });

        return $level;
    }

    public function delete(Level $level): Level
    {
        DB::transaction(function () use ($level) {
            $level->delete();
        });

        return $level;
    }
}
