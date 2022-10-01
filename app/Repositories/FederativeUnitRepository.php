<?php

namespace App\Repositories;

use App\Models\FederativeUnit;
use Illuminate\Support\Collection;

/**
 * Class FederativeUnitRepository
 * @package App\Repositories
 */
class FederativeUnitRepository extends Repository
{
    /**
     * @return Collection
     */
    public function listFederativeUnits(): Collection
    {
        return FederativeUnit::all();
    }
}
