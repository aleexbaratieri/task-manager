<?php

namespace Src\Users\Services;

use Src\Users\Repositories\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly UserRepositoryInterface $repo) {}

    /**
     * Retrieve all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection<array, \Src\Users\Models\User>
     */
    public function getUsers()
    {
        return $this->repo->getUsers();
    }

    /**
     * Retrieve a user by its ID.
     *
     * @param  string                                                       $id The ID of the user to retrieve.
     * @return \Illuminate\Database\Eloquent\Builder|\Src\Users\Models\User The user with the specified ID.
     */
    public function getUserById(string $id)
    {
        return $this->repo->getUserById($id);
    }

    /**
     * Create a new user with the given data.
     *
     * @param  array                  $data The data for creating the user.
     * @return \Src\Users\Models\User The newly created user.
     */
    public function createUser(array $data)
    {
        return $this->repo->createUser($data);
    }
}
