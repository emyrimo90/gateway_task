<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    use ModelTrait, SearchTrait;

    protected array $filters = ['duration', 'module', 'action',
        'user', 'userActions'
    ];

    public array $filterModels = ['User'];

    public function scopeOfDuration($query, $value)
    {
        return $query->whereDate('created_at','>=', Carbon::parse($value[0]))
            ->whereDate('created_at', '<=', Carbon::parse($value[1]));
    }

    public function scopeOfModule($query, $value)
    {
        return $query->where('properties->module', $value);
    }

    public function scopeOfAction($query, $value)
    {
        return $query->where('properties->action', $value);
    }

    public function scopeOfUser($query, $value)
    {
        return $query->where('causer_type', 'User')->where('causer_id', $value);
    }

    public function scopeOfUserActions($query)
    {
        return $query->whereNotNull('causer_type')->whereNotNull('causer_id');
    }
}
