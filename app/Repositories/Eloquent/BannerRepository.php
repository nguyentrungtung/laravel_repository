<?php

namespace App\Repositories\Eloquent;

use App\Models\Banner;
use App\Repositories\BannerRepositoryInterface;

class BannerRepository extends RelationModelRepository implements BannerRepositoryInterface
{
    protected $querySearchTargets = [
        // core here
    ];

    public function getBlankModel()
    {
        return new Banner;
    }
}
