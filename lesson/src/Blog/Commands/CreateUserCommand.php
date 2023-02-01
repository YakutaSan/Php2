<?php

namespace App\Blog\Commands;
use App\Blog\Exceptions\CommandException;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Name;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use App\Blog\User;
use App\Blog\UUID;

class CreateUserCommand
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    ) {
    }

    public function handle (Arguments $arguments): void
    {
        $username = $arguments->get('username');
        if ($this->userExists($username)) {
            throw new CommandException("User already exists: $username");
        }

        $this->usersRepository->save(
            new User(
                UUID::random(),
                new Name($arguments->get('first_name'), $arguments->get('last_name')),
                $username
            )
        );
    }

    private function userExists(string $username): bool
    {
        try {
            $this->usersRepository->getByUsername($username);
        } catch (UserNotFoundException) {
            return false;
        }
        return true;
    }
}