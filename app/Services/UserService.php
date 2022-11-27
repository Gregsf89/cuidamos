<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Helpers\TwilioHelper;
use App\Models\Account;
use App\Models\User;
use App\Models\UserInfo;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends Service
{
    private UserInfoRepository $userInfoRepository;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, UserInfoRepository $userInfoRepository)
    {
        $this->userRepository = $userRepository;
        $this->userInfoRepository = $userInfoRepository;
    }

    /**
     * Create a new user info
     * 
     * @param array $data the info to be added to the user
     * @param Account $account the account that owns the user
     * @return UserInfo
     */
    public function updateOrCreateUserInfo(array $data, Account $account): UserInfo
    {
        $userId = $account->user->id;

        return $this->userInfoRepository->updateOrCreate($data, $userId);
    }

    /**
     * Create a new user info
     * 
     * @param array $data the info to be added to the user
     * @param int $userId
     * @return User
     */
    public function updateUser(array $data, int $userId): User
    {
        $code = Helper::generateRandomPhoneToken();

        (new TwilioHelper())->sendSms(
            $data['phone_number'],
            "Você solicitou a validação do seu número de telefone pela Cuidam.os. Seu código de verificação é: {$code}. Caso não tenha solicitado, ignore este SMS."
        );
        return $this->userRepository->update($userId, $data);
    }

    /**
     * show
     *
     * @param int $userId
     * @return UserInfo The user's account model
     */
    public function show(int $userId): ?UserInfo
    {
        return $this->userInfoRepository->show($userId);
    }
}
