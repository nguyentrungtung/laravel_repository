<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository extends RelationModelRepository implements UserRepositoryInterface
{
    protected $querySearchTargets = [
        'email',
        'name',
        'phone',
        'address',
    ];

    public function getBlankModel()
    {
        return new User();
    }
}
