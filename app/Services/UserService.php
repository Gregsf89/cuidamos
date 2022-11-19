<?php

namespace App\Services;

use App\Models\UserInfo;
use App\Repositories\UserRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends Service
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user info
     * 
     * @param array $credentials The user credentials
     * @return array
     */
    public function create(array $credentials): array
    {
    }

    /**
     * Get the authenticated User.
     */
    public function show(): ?UserInfo
    {
        return $this->repository->create();
    }

    /**
     * Get the token array structure.
     * @param string $token
     * @return array
     */
    protected function delete(string $token): array
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
        ];
    }

    /**
     * Get the token array structure.
     * @param string $token
     * @return array
     */
    protected function update(string $token): array
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
        ];
    }
}
