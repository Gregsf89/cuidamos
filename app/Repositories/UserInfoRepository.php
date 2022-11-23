<?php

namespace App\Repositories;

use App\Models\UserInfo;

/**
 * Class UserInfoRepository
 * @package App\Repositories
 */
class UserInfoRepository extends Repository
{
    /**
     * createOrUpdate
     *
     * @param array $data
     * @param int $userId
     * @return UserInfo The user model requested
     */
    public static function updateOrCreate(array $data, int $userId): UserInfo
    {
        return UserInfo::updateOrCreate(['user_id' => $userId], $data)->fresh();
    }

    /**
     * show
     *
     * @param int $userId
     * @return UserInfo The user's account model
     */
    public function show(int $userId): ?UserInfo
    {
        return UserInfo::where('user_id', $userId)->first();
    }
}
