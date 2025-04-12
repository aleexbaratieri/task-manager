<?php

namespace Src\Users\Repositories;

use Src\Users\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly User $resource) {}

    /**
     * Retrieve all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \Src\Users\Models\User>
     */
    public function getUsers()
    {
        return $this->resource->all();
    }

    /**
     * Retrieve a user by its ID.
     *
     * @param  string                                                       $id The ID of the user to retrieve.
     * @return \Illuminate\Database\Eloquent\Builder|\Src\Users\Models\User The user with the specified ID.
     */
    public function getUserById(string $id)
    {
        return $this->resource->findOrFail($id);
    }

    /**
     * Create a new user with the given data.
     *
     * @param  array                  $data The data for creating the user.
     * @return \Src\Users\Models\User The newly created user.
     */
    public function createUser(array $data)
    {
        return $this->resource->create($data);
    }
}
