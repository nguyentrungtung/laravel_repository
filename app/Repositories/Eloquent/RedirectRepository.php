<?php

namespace App\Repositories\Eloquent;

use App\Models\Redirect;
use App\Repositories\RedirectRepositoryInterface;

class RedirectRepository extends RelationModelRepository implements RedirectRepositoryInterface
{
    protected $querySearchTargets = [
        // core here
    ];

    public function getBlankModel()
    {
        return new Redirect;
    }
    public function removeCheckbox($ids)
    {
        if (! $ids) {
            return;
        }
        $model = $this->getBlankModel()->whereIn('id', $ids)->delete();

        return $model;
    }

}
