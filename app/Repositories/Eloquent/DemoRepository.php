<?php

namespace App\Repositories\Eloquent;

use App\Repositories\DemoRepositoryInterface;
use App\Models\Demo;

class DemoRepository extends RelationModelRepository implements DemoRepositoryInterface
{

    protected $querySearchTargets = [
        'name'
    ];

    public function getBlankModel()
    {
        return new Demo();
    }
}
