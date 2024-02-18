<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Transaction extends Model
{
    use ModelTrait, SearchTrait;
    const STATUS_CANCELED = "CANCELED";

    protected $fillable = [
        'trace_id',
        'status',
        'payment_status',
        'currency',
        'amount',
        'comment',
        'paid_at',
        'data',
        'user_id',
        'gateway_setting_id',
    ];
    protected $searchable = [
        'trace_id',
        'status',
        'payment_status',
        'currency',
        'amount',
        'comment',
        'paid_at',
    ];
    protected array $filters = ['user', 'gatewaySetting'];

    // relations
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }

    public function gatewaySetting(): BelongsTo
    {
        return $this->BelongsTo(GatewaySetting::class, 'gateway_setting_id');
    }

    //scopes
    public function scopeOfUser($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereIn('user_id', (array)$value);
    }
    public function scopeOfGatewaySetting($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereIn('gateway_setting_id', (array)$value);
    }
}
