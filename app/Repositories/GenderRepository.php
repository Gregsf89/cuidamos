<?php

namespace App\Repositories;

use App\Models\Gender;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GenderRepository
 * @package App\Repositories
 */
class GenderRepository extends Repository
{
    /**
     * Gets gender's id by name
     *
     * @param string $name
     * @return int|null The user model requested
     */
    public static function getByName(string $name): ?int
    {
        return Gender::select('id')->where(['name' => $name])->pluck('id')->first();
    }

    /**
     * Get gender's name by id
     * @param int $id
     * @return string|null
     */
    public static function getById(int $id): ?string
    {
        return Gender::select('id', 'name')->where(['id' => $id])->pluck('name')->first();
    }

    /**
     * List all genders
     * @return Collection
     */
    public static function listGender(): Collection
    {
        return Gender::all();
    }
}
