<?php

namespace App\Blog\Repositories\CommentsRepository;

use App\Blog\Comment;
use App\Blog\Exceptions\CommentNotFoundException;
use App\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use App\Blog\UUID;
use \PDO;
use \PDOStatement;

class SqliteCommentsRepository implements CommentsRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function save(Comment $comment): void 
    {
        $statement = $this->connection->prepare(
            'INSERT INTO comments (uuid, post_uuid, author_uuid, text) 
            VALUES (:uuid, :post_uuid, :author_uuid, :text)'
        );

        $statement->execute([
            ':uuid' => $comment->getUuid(),
            ':post_uuid' => $comment->getPost()->getUuid(),
            ':author_uuid' => $comment->getUser()->uuid(),
            ':text' => $comment->getText()
        ]);
	}

    public function get(UUID $uuid): Comment 
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );

        $statement->execute([
            ':uuid' => $uuid,
        ]);

        return $this->getComment($statement, $uuid);
	}

    private function getComment(PDOStatement $statement, string $postUuid): Comment
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (false === $result) {
            throw new CommentNotFoundException(
                "Cannot get user: $postUuid"
            );
        }

        $userRepository = new SqliteUsersRepository($this->connection);
        $user = $userRepository->get(new UUID($result['author_uuid']));

        $postRepository = new SqlitePostsRepository($this->connection);
        $post = $postRepository->get(new UUID($result['post_uuid']));

        return new Comment(
            new UUID($result['uuid']),
            $user,
            $post,
            $result['text']
        );
    }
}