<?php

namespace App\Blog;

class User
{
    private UUID $uuid;
    private Name $name;
    private string $username;

    public function __construct(
        UUID $uuid, 
        Name $name, 
        string $username
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->username = $username;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function uuid(): UUID
    {
        return $this->uuid;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function __toString(): string
    {
        return "Юзер $this->uuid с именем $this->name и логином $this->username" . PHP_EOL;
    }
}