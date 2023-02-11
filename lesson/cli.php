<?php

use App\Blog\Command\Arguments;
use App\Blog\Command\CreateUserCommand;
use App\Blog\Exceptions\AppException;

$container = require __DIR__ . '/bootstrap.php';

$command = $container->get(CreateUserCommand::class);

try {
    $command->handle(Arguments::fromArgv($argv));
} catch (AppException $e) {
    echo "{$e->getMessage()}\n";
}