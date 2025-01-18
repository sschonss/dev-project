<?php

namespace App\Domains\Level\Controllers;

use App\Domains\Level\Requests\LevelRequest;
use App\Domains\Level\Services\LevelService;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class LevelController extends Controller
{
    use ApiResponseTrait;
    protected LevelService $service;

    public function __construct()
    {
        $this->service = new LevelService();
    }

    public function index(): JsonResponse
    {
        $levels = $this->service->getLevels();

        if ($levels->isEmpty()) {
            return $this->errorResponse('No Levels Found', 404);
        }

        return $this->successResponse($levels, 'Levels Fetched');
    }

    public function store(LevelRequest $request): JsonResponse
    {
        $data = $request->validated();
        $level = $this->service->createLevel($data);

        return $this->successResponse($level, 'Level Created', 201);
    }

    public function show(int $id): JsonResponse
    {
        $level = $this->service->getLevel($id);

        if (!$level) {
            return $this->errorResponse('Level Not Found');
        }

        return $this->successResponse($level, 'Level Fetched');

    }

    public function update(LevelRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $level = $this->service->updateLevel($data, $id);

        if (!$level) {
            return $this->errorResponse('Level Not Found');
        }

        return $this->successResponse($level, 'Level Updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $level = $this->service->deleteLevel($id);

        if (!$level) {
            return $this->errorResponse('Level Not Found');
        }

        return $this->successResponse($level, 'Level Deleted');
    }
}
