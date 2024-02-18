<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Notification extends Model
{
    use ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'body', 'data', 'read_at', 'redirect_id', 'redirect_type'];
    protected array $filters = ['userId', 'driverId'];

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'notifiable');
    }

    public function drivers(): MorphToMany
    {
        return $this->morphedByMany(Driver::class, 'notifiable');
    }

    //---------------------Scopes-------------------------------------
    public function scopeOfUserId($query, $value)
    {
        return $query->whereHas('users', function($query) use($value){
            $query->where('notifiable_id', $value);
        });
    }

    public function scopeOfDriverId($query, $value)
    {
        return $query->whereHas('drivers', function($query) use($value){
            $query->where('notifiable_id', $value);
        });
    }

}
