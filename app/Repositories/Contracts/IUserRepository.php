<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface IUserRepository
{
    /**
     * Checks if a user exists with the given identifier address.
     *
     * @param  string  $identifier The identifier address to check.
     * @return bool Returns `true` if a user exists with the given identifier, or `false` otherwise.
     */
    public function isUserExistsWithIdentifier(string $identifier): bool;

    /**
     * Check if a user with a given identifier  exists in the database.
     *
     * @param  string  $identifier The identifier of the user to check.
     * @return User Returns user if a user with the given identifier exists in the database,
     */
    public function findOrFailUserWithIdentifier(string $identifier): User;

    /**
     * Check if a user with a given email exists in the database if not create it.
     *
     * @param  string  $email of the user to check.
     * @return User Returns user.,
     */
    public function findOrCreateUserWithEmail(string $email): User;

    /**
     * Creates a new user in the database.
     *
     * @param  string  $identifier The identifier address for the new user.
     * @param  string  $password   The password for the new user.
     * @param  string|null  $name       The name of the new user.
     * @return bool Returns `true` if the user was successfully created, or `false` otherwise.
     */
    public function createNewUser(string $identifier, string $password, string|null $name): bool;

    /**
     * set new username for a user.
     *
     * @param  int  $id User Id.
     * @param  string  $username New Username.
     * @return User|mixed
     */
    public function setUserName(int $id, string $username);

    /**
     * check for usernames.
     *
     * @param  array  $usernames array of usernames.
     * @return array
     */
    public function checkUserNames(array $usernames);
}
