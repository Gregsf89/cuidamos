<?php

namespace App\Repositories;

use App\Models\Account;

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
        return Account::create($data)->fresh();
    }

    /**
     * Deletes an Account
     * 
     * @param int $accountId
     */
    public function delete(int $accountId): void
    {
        Account::where('id', $accountId)->forceDelete();
    }

    /**
     * Returns a Account by its id
     * 
     * @param int $accountId
     * @return Account|null
     */
    public function show(int $accountId): ?Account
    {
        return Account::where('id', $accountId)->first();
    }

    /**
     * Updates the info of a user
     * 
     * @param int $accountId
     * @param array $data
     * @return Account
     */
    public function update(int $accountId, array $data): Account
    {
        $account = $this->show($accountId);
        $account->fill($data)->save();
        return $account->fresh();
    }

    /**
     * Logou the user
     * 
     * @return void
     */
    public function logout(int $accountId): void
    {
        $account = $this->show($accountId);
        $account->remember_token = null;
        $account->save();
    }
}
