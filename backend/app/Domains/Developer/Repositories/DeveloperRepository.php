<?php

namespace App\Domains\Developer\Repositories;

use App\Domains\Developer\Models\Developer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DeveloperRepository
{
    protected Developer $developer;
    public function __construct()
    {
        $this->developer = new Developer();
    }

    public function save(array $data): Developer
    {
        $developer = $this->developer;

        foreach($data as $key => $value){
            $developer->$key = $value;
        }

        DB::transaction(function () use ($developer) {
            $developer->save();
        });

        return $developer;
    }

    public function all(): Collection
    {
        return $this->developer->all()?->load('level');
    }

    public function find(int $id): Developer|null
    {
        return $this->developer->newQuery()->find($id)?->load('level');
    }

    public function update(array $data, Developer $developer): Developer
    {
        foreach($data as $key => $value){
            $developer->$key = $value;
        }

        DB::transaction(function () use ($developer) {
            $developer->save();
        });

        return $developer;
    }

    public function delete(Developer $developer): Developer
    {
        DB::transaction(function () use ($developer) {
            $developer->delete();
        });

        return $developer;
    }
}
