<?php

namespace App\Repositories\Eloquent;

use App\Repositories\TestRepositoryInterface;
use App\Models\Test;

class TestRepository extends RelationModelRepository implements TestRepositoryInterface
{

    protected $querySearchTargets = [
        'name'
    ];

    public function getBlankModel()
    {
        return new Test();
    }
}
