<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CityRepository
 * @package App\Repositories
 * @author Pedro Augusto
 */
class CityRepository extends Repository
{
    /**
     * @param array $filters data to use as filter on the search, current 'state_code' and 'name'
     * @return array|null
     */
    public function searchCity(array $filters): ?Collection
    {
        $where = [];

        if (!empty($filters['city_name'])) {
            $where[] = ['name', 'like', "%{$filters['city_name']}%"];
        }

        if (!empty($filters['federative_unit_id'])) {
            $where[] = ['federative_unit_id', 'like', "%{$filters['federative_unit_id']}%"];
        }

        return City::select('id', 'name', 'federative_unit_id')
            ->where($where)
            ->orderBy('name')
            ->get();
    }
}
