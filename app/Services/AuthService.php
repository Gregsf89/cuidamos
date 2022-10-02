<?php

namespace App\Services;

use App\Helpers\JwtHelper;
use App\Wrappers\FirebaseWrapper;
use App\Repositories\AccountRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService extends Service
{
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

        $firebaseAuth = (new FirebaseWrapper());
        $accountRepository = (new AccountRepository());

        $loginInfo = $firebaseAuth->signInWithEmailAndPassword($credentials['email'], $credentials['password']);

        $account = $accountRepository->getByEmail($credentials['email']);

        $token = JwtHelper::buildToken([
            'sub' => $account->uid,
        ]);

        auth()->setUser($account);

        return [
            'token' => $this->respondWithToken($token)['token']
        ];
    }

    /**
     * Create a new Firebase user and local account
     * 
     * @param array $credentials The user credentials
     * @return array
     */
    public function create(array $credentials) //: array
    {
        $firebaseAuth = (new FirebaseWrapper());
        $accountRepository = (new AccountRepository());

        $userProperties  = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'emailVerified' => false
        ];

        $firebaseUser = $firebaseAuth->createUser($userProperties);

        $account = $accountRepository->create([
            'uid' => $firebaseUser['uid'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password'])
        ]);

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
