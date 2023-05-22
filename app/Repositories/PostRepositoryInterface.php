<?php

namespace App\Repositories;

interface PostRepositoryInterface extends RelationModelRepositoryInterface
{
    public function hotPost($type);

    public function newPost($limit);

    public function getDetailPost($slug);

    public function querySearch($data, $number);

    public function postType($id, $type, $limit);

    public function newss($id);

    public function removeCheckbox($ids);
}
