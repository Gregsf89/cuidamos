<?php

namespace App\Repositories;

use App\Models\State;
use Illuminate\Support\Collection;

/**
 * Class StateRepository
 * @package App\Repositories
 * @author Fernando Villas Boas
 */
class StateRepository extends Repository
{
    /**
     * @return Collection|null
     */
    public function enumerate(): ?Collection
    {
        return State::all();
    }

    public static function exists(string $state): bool
    {
        $state = State::where(['id' => $state])->first(); 

        if (!empty($state)) {
            return true;
        }

        return false;
    }
}
