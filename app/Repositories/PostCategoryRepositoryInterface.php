<?php

namespace App\Repositories;

interface PostCategoryRepositoryInterface extends RelationModelRepositoryInterface
{
    public function withChild($slug);

    public function getActivePostCategory();
}
