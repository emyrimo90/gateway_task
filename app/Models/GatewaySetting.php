<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GatewaySetting extends Model
{
    use ModelTrait, SearchTrait;

    const TEST_MODE ='TEST';
    const PRODUCTION_MODE ='PRODUCTION';

    const NOT_ACTIVE=0;
    const ACTIVE=1;
    protected $fillable = [
        'name',
        'type',
        'client_id',
        'client_secret',
        'status',
        'currency',
        'response_url',
        'cancel_url'
    ];
    protected array $filters = ['user', 'status', 'keyword'];
    protected array $searchable=['name', 'client_id', 'client_secret', 'type', 'currency'];
    protected $appends = ['status_text'];

    //appends
    public function getStatusTextAttribute(): string
    {
        return $this->status? __("active"):__("not_active");
    }
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }

    //scopes
    public function scopeOfUser($query, $value)
    {
        if(empty($value)){
            return $query;
        }
        return $value;
    }
    public function scopeOfStatus($query, $value)
    {
        return $query->whereIn('status', (array)$value);
    }
    public function scopeOfType($query, $value)
    {
        if (empty($value)){
            return $query;
        }
        return $query->whereIn('type', (array)$value);
    }
}
