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
     * @param string $uid
     * @return Account The user model requested
     */
    public static function getByUid(string $uid): ?Account
    {
        return Account::where('uid', $uid)->first();
    }

    /**
     * Gets an account by its email
     *
     * @param string $email
     * @return Account The Account's account model
     */
    public function getByEmail(string $email): ?Account
    {
        return Account::where('email', $email)->first();
    }

    /**
     * Creates a new Account
     * @param array $data
     * @return Account
     */
    public function create(array $data): ?Account
    {
        return (Account::updateOrCreate($data))->fresh();
    }

    /**
     * Deletes an Account
     * 
     * @param int $id
     */
    public function delete(int $id): void
    {
        Account::where('id', $id)->forceDelete();
    }

    /**
     * Returns a Account by its id
     * 
     * @param int $id
     * @return Account|null
     */
    public function show(int $id): ?Account
    {
        return Account::where('id', $id)->first();
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
