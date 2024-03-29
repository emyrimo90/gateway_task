<?php

namespace App\Repositories\SQL;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\UserContract;

class UserRepository extends BaseRepository implements UserContract
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes = []): mixed
    {
        $trashedEmail = $this->searchWithTrashed(['keyword' => $attributes['email']])->first();
        $this->freshRepo();
        $trashedPhone = $this->searchWithTrashed(['keyword' => $attributes['phone']])->first();
        $trashed = $trashedEmail ?? $trashedPhone;
        $role_id = $attributes['role_id'];
        $role = app(RoleContract::class)->find($role_id);
        if ($trashed) {
            $trashed->restore();
            $user = $this->update($trashed, $attributes);
        } else {
            $user = parent::create($attributes);
            $user->assignRole($role);
        }
        return $user;
    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $user = parent::update($model, $attributes);
        $user->syncRoles([$attributes['role_id']]);
        return $user->refresh();
    }
}
