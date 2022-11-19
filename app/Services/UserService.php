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
     * @param array $data the info to be added to the user
     * @return array
     */
    public function create(array $credentials): ?UserInfo
    {
        $user = $this->repository->getByUid($credentials['uid']);

        return $user->userInfo()->create($credentials);
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
    protected function delete(string $token): void
    {
        [
            'token' => $token,
            'token_type' => 'bearer',
        ];
    }

    /**
     * Get the token array structure.
     * @param string $token
     * @return UserInfo
     */
    protected function update(string $token): UserInfo
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
        ];
    }
}
