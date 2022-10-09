<?php

namespace App\Http\Controllers;

use Exception;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class testController extends Controller
{
    public function __construct()
    {
        $this->auth = app('firebase.auth');
    }

    public function get(): array
    {
        $email = 'greg.jfarias@gmail.com';
        $clearTextPassword = '123456';

        $this->auth->revokeRefreshTokens('S8tDfwGiB2UOyLndu4t6IimVP0O2');

        $signInResult = $this->auth->signInWithEmailAndPassword($email, $clearTextPassword);

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($signInResult->asTokenResponse()['id_token']);
            return [
                'user' => $verifiedIdToken->claims()->get('email'),
                'user_uid' => $verifiedIdToken->claims()->get('sub')
            ];
        } catch (FailedToVerifyToken) {
            throw new Exception('Failed to verify token', 500);
        }
    }
}
