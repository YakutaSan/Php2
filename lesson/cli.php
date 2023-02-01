<?php

use App\Blog\Command\Arguments;
use App\Blog\Command\CreateUserCommand;
use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;
include __DIR__ . '/vendor/autoload.php';

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

$usersRepository = new SqliteUsersRepository($connection);

$command = new CreateUserCommand($usersRepository);

try {
    $command->handle(Arguments::fromArgv($argv));
} catch (Exception $e) {
    echo $e->getMessage();
}