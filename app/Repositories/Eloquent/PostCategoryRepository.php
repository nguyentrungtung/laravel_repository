<?php

namespace App\Repositories\Eloquent;

use App\Models\PostCategory;
use App\Repositories\PostCategoryRepositoryInterface;

class PostCategoryRepository extends RelationModelRepository implements PostCategoryRepositoryInterface
{
    protected $querySearchTargets = [
        // core here
    ];

    public function getBlankModel()
    {
        return new PostCategory;
    }

    public function withChild($slug)
    {
        if ($slug == null) {
            $model = $this->getBlankModel();
        }
        $model = $this->getBlankModel()->where('slug', $slug)->where('status', 1)->with('childs')->first();

        return $model;
    }

    public function getActivePostCategory()
    {
        $model = $this->getBlankModel()->orderBy('updated_at', 'DESC')->where('status', 1)->get();

        return $model;
    }
}
