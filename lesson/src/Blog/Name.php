<?php

namespace App\Blog;

class Name
{
    private string $firstName;
    private string $lastName;

    public function __construct(
        string $firstName,
        string $lastName
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function first(): string
    {
        return $this->firstName;
    }

    public function last(): string
    {
        return $this->lastName;
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}