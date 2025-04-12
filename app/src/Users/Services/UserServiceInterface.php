<?php

namespace Src\Users\Services;

interface UserServiceInterface
{
    /**
     * Retrieve all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection<array, \Src\Users\Models\User>
     */
    public function getUsers();

    /**
     * Retrieve a user by its ID.
     *
     * @param  string                                                       $id The ID of the user to retrieve.
     * @return \Illuminate\Database\Eloquent\Builder|\Src\Users\Models\User The user with the specified ID.
     */
    public function getUserById(string $id);

    /**
     * Create a new user with the given data.
     *
     * @param  array                  $data The data for creating the user.
     * @return \Src\Users\Models\User The newly created user.
     */
    public function createUser(array $data);
}
