<?php

namespace App\Services\Auth;

use App\Data\Auth\UserData;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Fetches logged in user either by registration or external login in
     *
     * @param array $data The request data
     * @return User The logged user instance
     * @throws \Exception
     */
    public static function fetchLoggedInUser(array $data): User
    {
        try {
            $userData = UserData::from($data);
            $user = self::findUserByExternalId(externalId: $userData->google_id);

            if (!$user) {
                $user = self::createUser(userData: $userData);
            } else {
                self::updateUser(user: $user, userData: $userData);
            }

            return $user;
        } catch (\Exception $e) {
            \Log::error(msg: 'Error occurred while fetching or creating user: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Finds a user by external ID.
     *
     * @param string|null $externalId The external ID of the user.
     * @return User|null The user instance if found, or null if not found.
     */
    private static function findUserByExternalId(?string $externalId): ?User
    {
        return $externalId ? User::where('google_id', $externalId)->first() : null;
    }

    /**
     * Creates a new user.
     *
     * @param UserData $userData
     * @return User The created user instance.
     */
    private static function createUser(UserData $userData): User
    {
        return User::create($userData->toArray());
    }

    /**
     * Updates an existing user's data.
     *
     * @param User $user The user instance to be updated.
     * @param UserData $userData
     * @return void
     */
    private static function updateUser(User $user, UserData $userData): void
    {
        $user->update(Arr::only($userData->toArray(), ['name', 'pic']));
    }
}
