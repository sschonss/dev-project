<?php

namespace App\Domains\Developer\Services;

use App\Domains\Developer\Models\Developer;
use App\Domains\Developer\Repositories\DeveloperRepository;
use Illuminate\Database\Eloquent\Collection;

class DeveloperService
{
    private DeveloperRepository $developerRepository;

    public function __construct()
    {
        $this->developerRepository = new DeveloperRepository();
    }

    public function createDeveloper(array $data): Developer
    {
        $data = $this->formatDeveloperData($data);

        return $this->developerRepository->save($data);
    }

    public function getDevelopers(): Collection
    {
        return $this->developerRepository->all();
    }

    public function getDeveloper(int $id): ?Developer
    {
        return $this->developerRepository->find($id);
    }

    public function updateDeveloper(array $data, int $id): ?Developer
    {
        $data = $this->formatDeveloperData($data);

        $developer = $this->developerRepository->find($id);
        if (!$developer) {
            return $developer;
        }
        return $this->developerRepository->update($data, $developer);
    }

    public function deleteDeveloper(int $id): ?Developer
    {
        $developer = $this->developerRepository->find($id);
        if (!$developer) {
            return null;
        }
        return $this->developerRepository->delete($developer);
    }

    /**
     * @param array $data
     * @return array
     */
    public function formatDeveloperData(array $data): array
    {
        if (isset($data['name'])) {
            $data['name'] = ucfirst($data['name']);
        }
        if (isset($data['gender'])) {
            $data['gender'] = strtoupper($data['gender']);
        }
        if (isset($data['birth_date'])) {
            $data['birth_date'] = date('Y-m-d', strtotime($data['birth_date']));
        }
        return $data;
    }
}
