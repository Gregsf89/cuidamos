<?php

namespace App\Repositories;

use App\Models\Wardship;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class WardshipRepository
 * @package App\Repositories
 */
class WardshipRepository extends Repository
{
    /**
     * Display a listing of the resource.
     *
     * @param array $data
     * @return Wardship
     */
    public function updateOrCreate(array $data): Wardship
    {
        return Wardship::updateOrCreate(['document' => $data['document']], $data)->fresh();
    }

    /**
     * Show
     *
     * @param int $wardshipId
     * @return Wardship The user's account model
     */
    public function show(int $wardshipId): ?Wardship
    {
        return Wardship::where('wardship_id', $wardshipId)->first();
    }

    /**
     * List
     *
     * @param int $userId
     * @return Collection The user's account model
     */
    public function list(int $userId): ?Collection
    {
        return Wardship::where('user_id', $userId)->get();
    }

    /**
     * Show
     *
     * @param int $wardshipId
     * @return void
     */
    public function delete(int $wardshipId): void
    {
        Wardship::where('wardship_id', $wardshipId)->delete();
    }
}
