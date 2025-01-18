<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('developers', 'App\Domains\Developer\Controllers\DeveloperController')
    ->middleware('auth:sanctum');

Route::apiResource('levels', 'App\Domains\Level\Controllers\LevelController')
    ->middleware('auth:sanctum');

Route::post('register', 'App\Domains\Auth\Controllers\RegisteredUserController@store');

Route::post('login', 'App\Domains\Auth\Controllers\LoginController@login');

Route::post('logout', 'App\Domains\Auth\Controllers\LoginController@logout');
