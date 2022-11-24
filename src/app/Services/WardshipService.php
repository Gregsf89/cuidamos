<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wardship;
use App\Repositories\WardshipRepository;

/**
 * Class WardshipService
 * @package App\Services
 */
class WardshipService extends Service
{
    private WardshipRepository $repository;

    public function __construct(WardshipRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new wardship
     * 
     * @param array $data the info to be added to the user
     * @return Wardship
     */
    public function updateOrCreate(array $data): Wardship
    {
        return $this->repository->updateOrCreate($data);
    }

    /**
     * show a wardship
     *
     * @param int $wardshipId
     * @return Wardship The user's account model
     */
    public function show(int $wardshipId): ?Wardship
    {
        return $this->repository->show($userId);
    }
}
