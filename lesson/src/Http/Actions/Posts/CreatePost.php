<?php

namespace App\Http\Actions\Posts;
use App\Blog\Exceptions\AuthException;
use App\Blog\Exceptions\HttpException;
use App\Blog\Post;
use App\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use App\Blog\UUID;
use App\Http\Actions\ActionInterface;
use App\Http\Auth\IdentificationInterface;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessfulResponse;
use Psr\Log\LoggerInterface;


class CreatePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
// Внедряем контракт логгера
        private LoggerInterface $logger,
        private IdentificationInterface $identification,


    )
    {
    }

    /**
     * @throws AuthException
     * @throws \InvalidArgumentException
     */
    public function handle(Request $request): Response
    {
        $user = $this->identification->user($request);


        $newPostUuid = UUID::random();

        try {
            $post = new Post(
                $newPostUuid,
                $user,
                $request->jsonBodyField('title'),
                $request->jsonBodyField('text'),
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->save($post);
        $this->logger->info("Post created: $newPostUuid");

        return new SuccessfulResponse([
            'uuid' => (string)$newPostUuid,
        ]);
    }
}