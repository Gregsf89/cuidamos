<?php

namespace App\Services;

use App\Helpers\JwtHelper;
use App\Wrappers\FirebaseWrapper;
use App\Repositories\AccountRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Exception;

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
        if (!auth()->attempt($credentials, true)) {
            abort(401, "invalid_username_and_or_password");
        }
        $authInfo = (new FirebaseWrapper())->verifyUserToken($userToken);

        $account = (new AccountRepository())->getByUsername($credentials['username']);
        auth()->setUser($account);
        $token = JwtHelper::buildToken([
            "sub" => $account->uuid,
        ]);
        (new AccountService())->update($account->id, ['last_access' => now()]);


        auth()->setUser($account); //Define o account como o usuário autenticado
        //Gera o token do usuário
        $token = JwtHelper::buildToken(['sub' => $account->uuid]);

        //Registra um novo dispositivo / Reativa um dispositivo desativado da conta / Atualiza o dispositivo existente
        (new AccountDeviceService())->registerDevice($account->id, $deviceInfo);

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
     * Refresh a token.
     * @return array
     */
    public function refresh(): array
    {
        $service = new AccountService();
        $service->update(auth()->user()->id, ['last_access' => now()]);
        $token = JwtHelper::buildToken([
            "sub" => auth()->user()->uuid,
        ]);

        return [
            'auth_info' => auth()->user(),
            'token' => $this->respondWithToken($token)['token']
        ];
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
