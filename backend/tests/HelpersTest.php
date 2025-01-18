<?php

namespace Tests;

use App\Domains\Auth\Models\User;
use App\Domains\Developer\Models\Developer;
use App\Domains\Level\Models\Level;

trait HelpersTest
{
    public function createLevel(string $level): Level
    {
        return Level::create(['level' => $level]);
    }

    public function createUser(): User
    {
        return User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function createDeveloper(
        string $name,
        string $gender,
        string $birth_date,
        string $hobby,
        int $level_id = null
    ): Developer {
        if (is_null($level_id)) {
            $level = $this->createLevel('Junior');
            $level_id = $level->id;
        }

        return Developer::create([
            'name' => $name,
            'level_id' => $level_id,
            'gender' => $gender,
            'birth_date' => $birth_date,
            'hobby' => $hobby,
        ]);
    }

    public function login(User $user): string
    {
        return $user->createToken('test')->plainTextToken;
    }
}
