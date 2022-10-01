<?php

namespace App\Repositories;

use App\Models\City;

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
    public function search(array $filters): ?array
    {
        $where = array();
        $state_code = $filters['state_code'];

        if (!empty($filters['name'])) {
            $where[] = ['name', 'like', "%{$filters['name']}%"];
        }

        return City::select('name', 'id')
            ->where('state_id', '=', $state_code)
            ->where($where)
            ->orderBy('name')
            ->get()
            ->all();
    }
}
