<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\IProfileRepository;
use App\Repositories\Contracts\IUserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;
use Throwable;

/**
 * Class UserRepository
 */
class UserRepository extends BaseRepository implements IUserRepository
{
    /**
     * The model to be used by this repository
     */
    protected string $model = User::class;

    /**
     * {@inheritDoc}
     */
    public function isUserExistsWithIdentifier(string $identifier): bool
    {
        return $this->getModel()->where('identifier', $identifier)->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function createNewUser(string $identifier, string $password, string|null $name = ''): bool
    {
        $profileRepository = app()->make(IProfileRepository::class);

        try {
            $user = new User(
                [
                    'name' => $name,
                    'identifier' => $identifier,
                    'password' => $password,
                ]
            );
            $user->save();
            $profileRepository->createEmptyProfileForUser($user->id);

            return true;
        } catch (\Exception $e) {
            // Handle the exception appropriately, e.g. log the error or re-throw it
            throw $e;

            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findOrFailUserWithIdentifier(string $identifier): User
    {
        try {
            $user = $this->getModel()->where('identifier', $identifier)->firstOrFail();
            if ($user) {
                return $user;
            }
            throw new UnauthorizedException();
        } catch (ModelNotFoundException $e) {
            // Handle the exception appropriately, e.g. log the error or re-throw it
            throw $e;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setUserName(int $id, string $username)
    {
        return $this->getModel()->find($id)->update(
            [
                'username' => $username,
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function checkUserNames(array $usernames)
    {
        return $this->getModel()->whereIn('username', $usernames)->pluck('username')->toArray();
    }

    /**
     * Get a user with the given identifier address from the database.
     *
     * @param  string  $identifier The identifier address of the user to get.
     * @return User|null The user with the given identifier address, or null if no user is found.
     */
    private function getUserByIdentifier(string $identifier): ?User
    {
        try {
            return $this->getModel()->where('identifier', $identifier)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle the exception appropriately, e.g. log the error or re-throw it
            return null;
        }
    }

    public function findOrCreateUserWithEmail(string $email): User
    {
        try {
            return $this->findOrFailUserWithIdentifier($email);
        } catch (Exception|Throwable $e) {
            $profileRepository = app()->make(IProfileRepository::class);

            $user = new User(
                [
                    'name' => '',
                    'identifier' => $email,
                    'password' => '',
                ]
            );
            $user->save();
            $profileRepository->createEmptyProfileForUser($user->id);

            return $user;
        }
    }
}
