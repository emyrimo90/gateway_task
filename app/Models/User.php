<?php

namespace App\Models;

use App\Constants\FileConstants;
use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelTrait, HasRoles, HasPermissions, SearchTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'phone', 'password', 'is_active'];
    public array $filterModels = ['Warehouse', 'Segment'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime'];
    protected array $filters = ['keyword', 'role', 'permission'];
    protected array $searchable = ['name','phone','email'];

    public function avatar(): MorphOne
    {
        return $this->morphOne(File::class,'fileable')
            ->where('type', FileConstants::FILE_TYPE_USER_AVATAR->value);
    }

    public function setPasswordAttribute($input): void
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function scopeOfRole($query, $value)
    {
        return $query->whereHas('roles', function($query) use ($value){
            $query->where('id', $value);
        });
    }

    public function scopeOfPermission($query, $value)
    {
        return $query->permission($value);
    }

    public function notifications(): MorphToMany
    {
        return $this->morphToMany(Notification::class,'notifiable');
    }

    public function segments(): MorphToMany
    {
        return $this->morphToMany(Segment::class, 'segmentable')->whereNull('parent_id')->withTimestamps();
    }

    public function subSegments(): MorphToMany
    {
        return $this->morphToMany(Segment::class, 'segmentable')->whereNotNull('parent_id')->withTimestamps();
    }

    public function warehouses(): MorphToMany
    {
        return $this->morphToMany(Warehouse::class, 'warehouseable')->withTimestamps();
    }

}
