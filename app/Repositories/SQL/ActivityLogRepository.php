<?php

namespace App\Repositories\SQL;

use App\Models\ActivityLog;
use App\Repositories\Contracts\ActivityLogContract;
use Illuminate\Support\Facades\Storage;

class ActivityLogRepository extends BaseRepository implements ActivityLogContract
{
    /**
     * ActivityLogRepository constructor.
     * @param ActivityLog $model
     */
    public function __construct(ActivityLog $model)
    {
        parent::__construct($model);
    }

    public function getModulesActions(): array
    {
        $modelFiles = Storage::disk('app')->files('Models');
        $except = ['ActivityLog'];
        $modules = collect($modelFiles)->map(function ($modelFile) {
            return str_replace(array('.php', 'Models/'), '', $modelFile);
        });
        $modules = $modules->filter(function ($module) use ($except) {
            return !in_array($module, $except, true);
        });
        $actions = ['Creation', 'Update', 'Removing'];
        return ['modules' => $modules, 'actions' => $actions];
    }
}
