<?php

namespace App\Repositories;

use App\Models\User;
use Exception;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends Repository
{
    /**
     * Gets an user by its uid
     *
     * @param String $uid
     * @return User The user model requested
     */
    public static function getByUid(string $uid): User
    {
        return User::where(['uid' => $uid])->firstOrFail();
    }

    /**
     * Gets an account by its username
     *
     * @param string $email
     * @return User The user's account model
     */
    public function getByEmail(string $email): User
    {
        return User::where(['email' => $email])->firstOrFail();
    }

    /**
     * Creates a new user
     * @param array $data
     * @return Model
     */
    public function create(array $data): User
    {
        if ($this->getByUid($data['uid'])) {
            throw new Exception('uid_already_exists', 504);
        }

        return (User::create($data))->fresh();
    }

    /**
     * Deletes an user
     * 
     * @param int $id
     */
    public function delete(int $id): void
    {
        User::where(['id' => $id])->forceDelete();
    }

    /**
     * Returns a user by its id
     * 
     * @param int $id
     * @return User|null
     */
    public function show(int $id): ?User
    {
        return User::where('id', $id)->firstOrFail();
    }

    /**
     * Updates the info of a user
     * 
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update(int $id, array $data): User
    {
        $account = $this->show($id);
        $account->fill($data)->save();
        return $account->fresh();
    }
}
