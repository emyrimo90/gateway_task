<?php

namespace App\Repositories\SQL;

use App\Models\Role;
use App\Repositories\Contracts\RoleContract;

class RoleRepository extends BaseRepository implements RoleContract
{
    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

}
