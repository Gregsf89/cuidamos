<?php

namespace App\Services;

use App\Repositories\CityRepository;
use App\Repositories\FederativeUnitRepository;
use App\Repositories\GenderRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ResourceService
 * @package App\Services
 */
class ResourceService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @param array $filters
     * @return Collection|null
     */
    public function searchCity(array $filters): ?Collection
    {
        if (empty($filters['city_name'])) {
            unset($filters['city_name']);
        }
        if (empty($filters['federative_unit_id'])) {
            unset($filters['federative_unit_id']);
        }

        return (new CityRepository())->searchCity($filters);
    }

    public function listFederativeUnits(): Collection
    {
        return (new FederativeUnitRepository())->listFederativeUnits();
    }

    public function listGender(): Collection
    {
        return (new GenderRepository())->listGender();
    }
}
