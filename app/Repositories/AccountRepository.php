<?php

namespace App\Repositories;

use App\Models\Account;
use Exception;

/**
 * Class AccountRepository
 * @package App\Repositories
 */
class AccountRepository extends Repository
{
    /**
     * Gets an account by its uid
     *
     * @param string $uuid
     * @return Account The user model requested
     */
    public static function getByUuid(string $uuid): Account
    {
        return Account::where(['uuid' => $uuid])->firstOrFail();
    }

    /**
     * Gets an account by its email
     *
     * @param string $email
     * @return Account The Account's account model
     */
    public function getByEmail(string $email): Account
    {
        return Account::where(['email' => $email])->firstOrFail();
    }

    /**
     * Creates a new Account
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account
    {
        if ($this->getByUuid($data['uid'])) {
            throw new Exception('uid_already_exists', 504);
        }

        return (Account::create($data))->fresh();
    }

    /**
     * Deletes an Account
     * 
     * @param int $id
     */
    public function delete(int $id): void
    {
        Account::where(['id' => $id])->forceDelete();
    }

    /**
     * Returns a Account by its id
     * 
     * @param int $id
     * @return Account|null
     */
    public function show(int $id): ?Account
    {
        return Account::where('id', $id)->firstOrFail();
    }

    /**
     * Updates the info of a user
     * 
     * @param int $id
     * @param array $data
     * @return Account
     */
    public function update(int $id, array $data): Account
    {
        $account = $this->show($id);
        $account->fill($data)->save();
        return $account->fresh();
    }
}
