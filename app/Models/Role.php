<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends \Spatie\Permission\Models\Role
{
    use ModelTrait, SearchTrait;

    public const DEFAULT_ROLE_SUPER_ADMIN = 'Super Admin';
    public const DEFAULT_ROLE_EMPLOYEE = 'Employee';
    public const DEFAULT_ROLE = [self::DEFAULT_ROLE_SUPER_ADMIN, self::DEFAULT_ROLE_EMPLOYEE];
    public const FIXED_ROLE_ADMIN = 1;
    public const FIXED_ROLE_EMPLOYEE = 2;
    public const ADDITIONAL_PERMISSIONS = [];
    protected array $filters = ['keyword', 'type'];
    protected array $searchable = ['name'];

    public array $definedRelations = ['users'];

    public function scopeOfType($query, $type=null)
    {
        if(($type === 'new') || $type === 'exist'){
            $query=$query->whereNotIn('id',[self::FIXED_ROLE_EMPLOYEE]);
        }
        return $query;
    }

}
