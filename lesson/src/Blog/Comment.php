<?php

namespace App\Blog;

class Comment
{
    public function __construct(
        private UUID $uuid,
        private User $user,
        private Post $post,
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

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function __toString()
    {
        return $this->user . ' пишет Коммент ' . $this->text;
    }
}