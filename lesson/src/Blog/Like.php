<?php

namespace App\Blog;

class Like
{
    public function __construct(
        private UUID $uuid,
        private UUID $post_id,
        private UUID $user_id,
    )
    {
    }

    
    public function uuid(): UUID
    {
        return $this->uuid;
    }

    public function setUuid(UUID $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getPostId(): UUID
    {
        return $this->post_id;
    }

    public function setPostId(UUID $post_id): void
    {
        $this->post_id = $post_id;
    }

    public function getUserId(): UUID
    {
        return $this->user_id;
    }

    public function setUserId(UUID $user_id): void
    {
        $this->user_id = $user_id;
    }
}