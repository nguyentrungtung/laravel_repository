<?php

namespace App\Repositories\Eloquent;

use App\Repositories\LogRepositoryInterface;
use App\Models\Log;

class LogRepository extends RelationModelRepository implements LogRepositoryInterface
{

    protected $querySearchTargets = [
        'name'
    ];

    public function getBlankModel()
    {
        return new Log();
    }
}
