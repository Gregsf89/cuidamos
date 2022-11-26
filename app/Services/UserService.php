<?php

namespace App\Services;

use App\Models\Account;
use App\Models\UserInfo;
use App\Repositories\UserInfoRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends Service
{
    private UserInfoRepository $repository;

    public function __construct(UserInfoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user info
     * 
     * @param array $data the info to be added to the user
     * @param Account $account the account that owns the user
     * @return UserInfo
     */
    public function updateOrCreate(array $data, Account $account): UserInfo
    {
        $userId = $account->user->id;

        return $this->repository->updateOrCreate($data, $userId);
    }

    /**
     * show
     *
     * @param int $userId
     * @return UserInfo The user's account model
     */
    public function show(int $userId): ?UserInfo
    {
        return $this->repository->show($userId);
    }
}
