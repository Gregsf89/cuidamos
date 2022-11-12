<?php

namespace App\Services;

use App\Helpers\JwtHelper;
use App\Wrappers\FirebaseWrapper;
use App\Repositories\AccountRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Exception;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 * @package App\Services
 * @author Fernando Villas Boas
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
        $firebaseAuth = (new FirebaseWrapper());
        $accountRepository = (new AccountRepository());

        $loginInfo = $firebaseAuth->signInWithEmailAndPassword($credentials['email'], $credentials['password']);

        dd($loginInfo);

        $account = (new AccountRepository())->getByUsername($credentials['username']);
        auth()->setUser($account);
        $token = JwtHelper::buildToken([
            "sub" => $account->uuid,
        ]);


        auth()->setUser($account); //Define o account como o usuário autenticado
        //Gera o token do usuário
        $token = JwtHelper::buildToken(['sub' => $account->uuid]);

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

        try {
            $account = $accountRepository->create([
                'uid' => $firebaseUser['uid'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password'])
            ]);
        } catch (Exception) {
            $firebaseAuth->deleteUser($firebaseUser['uid']);
            throw new Exception('error_storing_the_account_on_database', 100091);
        }

        auth()->setUser($account); //Define o account como o usuário autenticado        
        $token = JwtHelper::buildToken(['sub' => $account->uid]); //Gera o token do usuário

        return [
            'token' => $this->respondWithToken($token)['token']
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
