<?php

namespace App\Blog\Repositories\UsersRepository;

use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Name;
use App\Blog\User;
use App\Blog\UUID;
use \PDO;
use \PDOStatement;

class SqliteUsersRepository implements UsersRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function save(User $user): void
    {
        // Подготавливаем запрос
        $statement = $this->connection->prepare(
            'INSERT INTO users (first_name, last_name, uuid, username) 
            VALUES (:first_name, :last_name, :uuid, :username)'
        );

        // Выполняем запрос с конкретными значениями
        $statement->execute([
            ':first_name' => $user->name()->first(),
            ':last_name' => $user->name()->last(),
            ':uuid' => $user->uuid(),
            ':username' => $user->username()
        ]);
    }

    public function get(UUID $uuid): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = ?'
        );

        $statement->execute([(string)$uuid]);

        return $this->getUser($statement, $uuid);
    }

    public function getByUsername(string $username): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE username = :username'
        );

        $statement->execute([
            ':username' => $username,
        ]);

        return $this->getUser($statement, $username);
    }

    private function getUser(PDOStatement $statement, string $username): User
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (false === $result) {
            throw new UserNotFoundException(
                "Cannot get user: $username"
            );
        }

        return new User(
            new UUID($result['uuid']),
            new Name($result['first_name'], $result['last_name']),
            $result['username']
        );
    }
}