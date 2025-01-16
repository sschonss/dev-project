<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('developer', 'App\Http\Controllers\DeveloperController');
Route::apiResource('level', 'App\Domains\Level\Controllers\LevelController');

