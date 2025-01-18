<?php

namespace App\Domains\Developer\Controllers;

use App\Domains\Developer\Requests\DeveloperRequest;
use App\Domains\Developer\Requests\DeveloperUpdateRequest;
use App\Domains\Developer\Services\DeveloperService;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class DeveloperController extends Controller
{
    use ApiResponseTrait;

    protected DeveloperService $service;

    public function __construct()
    {
        $this->service = new DeveloperService();
    }

    public function index(): JsonResponse
    {
        $developers = $this->service->getDevelopers();

        if ($developers->isEmpty()) {
            return $this->errorResponse('No Developers Found', 404);
        }

        return $this->successResponse($developers, 'Developers Fetched');
    }

    public function store(DeveloperRequest $request): JsonResponse
    {
        $data = $request->validated();
        $developer = $this->service->createDeveloper($data);

        return $this->successResponse($developer, 'Developer Created', 201);
    }

    public function show(int $id): JsonResponse
    {
        $developer = $this->service->getDeveloper($id);

        if (!$developer) {
            return $this->errorResponse('Developer Not Found');
        }

        return $this->successResponse($developer, 'Developer Fetched');
    }

    public function update(DeveloperUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $developer = $this->service->updateDeveloper($data, $id);

        if (!$developer) {
            return $this->errorResponse('Developer Not Found');
        }

        return $this->successResponse($developer, 'Developer Updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $developer = $this->service->deleteDeveloper($id);

        if (!$developer) {
            return $this->errorResponse('Developer Not Found');
        }

        return $this->successResponse($developer, 'Developer Deleted');
    }
}
