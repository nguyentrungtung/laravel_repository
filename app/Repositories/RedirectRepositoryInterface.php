<?php

namespace App\Repositories;

interface RedirectRepositoryInterface extends RelationModelRepositoryInterface
{
    public function removeCheckbox($ids);
}
