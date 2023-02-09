<?php

namespace App\Http\Actions\Posts;
use App\Blog\Exceptions\PostNotFoundException;
use App\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use App\Blog\UUID;
use App\Http\Actions\ActionInterface;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessfulResponse;

class DeletePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    ){}

    public function handle(Request $request): Response
    {
        try {
            $postUuid = $request->query('uuid');
            $this->postsRepository->get(new UUID($postUuid));
        } catch (PostNotFoundException $error) {
            return new ErrorResponse($error->getMessage());
        }

        $this->postsRepository->delete(new UUID($postUuid));

        return new SuccessfulResponse([
            'uuid' => $postUuid,
        ]);
    }
}