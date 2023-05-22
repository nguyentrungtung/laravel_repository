<?php

namespace App\Repositories\Eloquent;

use App\Models\PostComment;
use App\Repositories\PostCommentRepositoryInterface;

class PostCommentRepository extends RelationModelRepository implements PostCommentRepositoryInterface
{
    protected $querySearchTargets = [
        // core here
    ];

    public function getBlankModel()
    {
        return new PostComment;
    }

    public function getPostCommentRender($id)
    {
        $postId = $id;
        if ($postId == null) {
            $model = $this->getBlankModel();
        }
        $model = $this->getBlankModel()->where('post_id', $postId)->where('status', 1)->get();

        return $model;
    }

    public function soft($method, $postId)
    {
        switch ($method) {
            case 'ascending':
              $model = $this->getBlankModel()->orderBy('created_at', 'asc')->where('post_id', $postId)->where('status', 1)->get();
              break;
            case 'descending':
                $model = $this->getBlankModel()->orderBy('created_at', 'desc')->where('post_id', $postId)->where('status', 1)->get();
              break;
            default:
                $model = $this->getBlankModel()->orderBy('created_at', 'asc')->where('post_id', $postId)->where('status', 1)->get();
          }

        return $model;
    }
}
