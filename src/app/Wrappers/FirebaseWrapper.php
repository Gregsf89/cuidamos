<?php

namespace App\Wrappers;

use Exception;
use Kreait\Firebase\Exception\Auth\EmailExists;
use Kreait\Firebase\Exception\Auth\EmailNotFound;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\AuthException;

class FirebaseWrapper
{
    protected $_auth;
    protected $_messaging;

    public function __construct()
    {
        $this->_auth = app('firebase.auth');
        $this->_messaging = app('firebase.messaging');
    }

    /**
     * Função responsável por verificar se o idToken do usuário é válido
     * 
     * @param string idToken The firebase user idToken
     * @return array|null
     * @throws FailedToVerifyToken
     */
    public function verifyUserToken(string $idToken): ?array
    {
        try {
            $user = $this->_auth->verifyIdToken($idToken);
            return [
                'name' => $user->claims()->get('name'),
                'email' => $user->claims()->get('email'),
                'uid' => $user->claims()->get('user_id'),
                'providers' => $user->claims()->get('firebase')
            ];
        } catch (Exception) {
            abort(401, 'invalid_user');
        }
    }

    /**
     * Função responsável por desvincular usuário de provider (Google, Facebook, etc)
     * 
     * @param string $uid The firebase user id
     * @param string $provider The provider id (Eg.: google.com, apple.com, facebook.com)
     * @return void
     */
    public function unlinkProvider(string $uid, string $provider): void
    {
        $this->_auth->unlinkProvider($uid, $provider);
    }

    /**
     * Função responsável ativar um usuário
     * 
     * @param string $uid The firebase user id
     * @return void
     */
    public function enableUser(string $uid): void
    {
        $this->_auth->enableUser($uid);
    }

    /**
     * Função responsável desativar um usuário
     * 
     * @param string $uid The firebase user id
     * @return void
     */
    public function disableUser(string $uid): void
    {
        $this->_auth->disableUser($uid);
    }

    /**
     * Função responsável deletar (hard delete) um usuário
     * 
     * @param string $uid The firebase user id
     * @return void
     */
    public function deleteUser(string $uid): void
    {
        $this->_auth->deleteUser($uid);
    }

    /**
     * Loga o usuário no Firebase através do uid
     * 
     * @param string uid The firebase user uid
     * @return array
     */
    public function signInWithUid(string $uid): array
    {
        $user = $this->_auth->signInAsUser($uid, null);
        return [
            'id_token' => $user->idToken(),
            'access_token' => $user->accessToken(),
            'refresh_token' => $user->refreshToken(),
        ];
    }

    /**
     * Função responsável por recuperar dados do usuário pelo uid
     * 
     * @param string|null $uid The user uid
     * @param string|null $email The user email
     * @return array The user data
     */
    public function getUserData(?string $uid, ?string $email): array
    {
        try {
            $user = null;
            if (empty($uid)) {
                $user = $this->_auth->getUserByEmail($email);
            } else if (empty($email)) {
                $user = $this->_auth->getUser($uid);
            }
            if (!empty($user)) {
                $providers = [];
                foreach ($user->providerData as $provider) {
                    $providers[] = [
                        'provider_uid' => $provider->uid,
                        'provider_id' => $provider->providerId
                    ];
                }
                return [
                    'uid' => $user->uid,
                    'name' => $user->displayName,
                    'email' => $user->email,
                    'phone' => $user->phoneNumber,
                    'provider' => $providers,
                    'email_verified' => $user->emailVerified,
                    'status' => ($user->disabled) ? 'INACTIVE' : 'ACTIVE'
                ];
            }
            return [];
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound) {
            throw new UserNotFound('invalid_user_uid', 100089);
        }
    }

    /**
     * Faz o login do usuário com email e senha
     * 
     * @param string $email The user email
     * @param string $password The user password
     * @return array The user data
     */
    public function signInWithEmailAndPassword(string $email, string $password): array
    {
        $user = $this->_auth->signInWithEmailAndPassword($email, $password);
        return [
            'id_token' => $user->idToken(),
            'firebase_user_id' => $user->firebaseUserId(),
            'access_token' => $user->accessToken(),
            'refresh_token' => $user->refreshToken(),
        ];
    }

    /**
     * Função responsável criar um novo usuário no firebase
     * 
     * @param array $userProperties The user properties
     * @return array The user data
     */
    public function createUser(array $userProperties): array
    {
        try {
            $user = $this->_auth->createUser($userProperties);
            $emailLink = $this->getEmailVerificationLink($userProperties['email']);
            return [
                'uid' => $user->uid,
                'email_link_confirmation' => $emailLink
            ];
        } catch (\Kreait\Firebase\Exception\Auth\EmailExists) {
            throw new EmailExists('email_already_exists', 100090);
        }
    }

    /**
     * Função responsável por enviar uma mensagem para o usuário
     * 
     * @param string $email The user email
     * @return string The email verification link
     */
    public function getEmailVerificationLink(string $email): string
    {
        try {
            return $this->_auth->getEmailVerificationLink($email);
        } catch (\Kreait\Firebase\Exception\Auth\EmailNotFound) {
            throw new EmailNotFound('invalid_email', 100089);
        }
    }

    /**
     * Função responsável deletar um usuário do firebase
     * 
     * @param string $uid The user uid
     */
    public function deleteUserByUid(string $uid): void
    {
        try {
            $this->_auth->deleteUser($uid);
        } catch (UserNotFound $e) {
            throw new Exception($e->getMessage());
        } catch (AuthException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
