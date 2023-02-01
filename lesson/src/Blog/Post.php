<?php

namespace App\Blog;

class Post
{
    public function __construct(
        private UUID $uuid,
        private User $user,
        private string $title,
        private string $text
    )
    {
    }

    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function __toString()
    {
        return $this->user . ' пишет: ' . $this->text . PHP_EOL;
    }
}