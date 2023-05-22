<?php

namespace App\Repositories;

interface PostCommentRepositoryInterface extends RelationModelRepositoryInterface
{
    public function getPostCommentRender($id);

    public function soft($method, $postId);
}
