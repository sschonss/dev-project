<?php

namespace App\Domains\Developer\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DeveloperController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Developers Index'
        ]);
    }

    public function store(): JsonResponse
    {
        return response()->json([
            'message' => 'Developers Store'
        ]);
    }

    public function show(): JsonResponse
    {
        return response()->json([
            'message' => 'Developers Show'
        ]);
    }

    public function update(): JsonResponse
    {
        return response()->json([
            'message' => 'Developers Update'
        ]);
    }

    public function destroy(): JsonResponse
    {
        return response()->json([
            'message' => 'Developers Destroy'
        ]);
    }
}
