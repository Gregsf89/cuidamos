<?php

namespace App\Services;

use App\Helpers\JwtHelper;
use App\Wrappers\FirebaseWrapper;
use App\Repositories\AccountRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Exception;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService extends Service
{
    private AccountRepository $accountRepository;
    private UserRepository    $userRepository;
    private FirebaseWrapper   $firebaseWrapper;

    public function __construct(AccountRepository $accountRepository, UserRepository $userRepository, FirebaseWrapper $firebaseWrapper)
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository    = $userRepository;
        $this->firebaseWrapper   = $firebaseWrapper;
    }

    /**
     * Get a JWT via given credentials.
     * 
     * @param array $credentials The user credentials
     * @return array
     */
    public function login(array $credentials): array
    {
        if (!auth()->attempt($credentials, true)) {
            abort(401, 'invalid_username_and_or_password');
        }

        $loginInfo = $this->firebaseWrapper->signInWithEmailAndPassword($credentials['email'], $credentials['password']);

        $account = $this->accountRepository->getByEmail($credentials['email']);

        $token = JwtHelper::buildToken([
            'sub' => $account->uid,
        ]);

        auth()->setUser($account);

        return [
            'token' => $this->respondWithToken($token)['token'],
            'email_verified' => $this->firebaseWrapper->getUserData($loginInfo['firebase_user_id'], null)['email_verified']
        ];
    }

    /**
     * Create a new Firebase user and local account
     * 
     * @param array $credentials The user credentials
     * @return array
     */
    public function create(array $credentials): array
    {
        $userProperties  = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'emailVerified' => false
        ];

        $firebaseUser = $this->firebaseWrapper->createUser($userProperties);

        try {
            $account = $this->accountRepository->create([
                'uid' => $firebaseUser['uid'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password'])
            ]);

            $this->userRepository->create([
                'account_id' => $account->id,
                'email' => $credentials['email'],
                'uid' => $firebaseUser['uid'],
                'phone' => ' '
            ]);
        } catch (Exception) {
            $this->firebaseWrapper->deleteUser($firebaseUser['uid']);
            throw new Exception('error_storing_the_account_on_database', 100091);
        }

        auth()->setUser($account); //Define o account como o usuário autenticado        
        $token = JwtHelper::buildToken(['sub' => $account->uid]); //Gera o token do usuário

        return [
            'token' => $this->respondWithToken($token)['token'],
            'email_link_confirmation' => $firebaseUser['email_link_confirmation']
        ];
    }

    /**
     * Get the authenticated User.
     */
    public function show(): ?Authenticatable
    {
        return auth()->user();
    }

    /**
     * Get the token array structure.
     * @param string $token
     * @return array
     */
    protected function respondWithToken(string $token): array
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
        ];
    }
}
