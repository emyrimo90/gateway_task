<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use \Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    use ModelTrait;

    public const ADDITIONAL_PERMISSIONS = [
    ];

    protected static mixed $abilities;
    protected static mixed $models;
    protected static mixed $permissions;
    protected array $filters = [];

    public static function defaultPermissions(): array
    {
        self::$permissions = [];
        self::$abilities = collect(['create', 'read', 'update', 'delete']);
        $modelFiles = Storage::disk('app')->files('Models');
        self::$models = collect($modelFiles)->map(function ($modelFile) {
            $model = str_replace(array('.php', 'Models/'), '', $modelFile);
            $modelClass = 'App\\Models\\' . str_replace('/', '\\', $model);
            self::$abilities->map(function ($ability) use ($model) {
                $perm = $ability . Str::lower(implode('_', preg_split('/(?=[A-Z])/', $model)));
                self::$permissions[] = ['name' => $perm, 'model' => $model,'guard_name'=>'sanctum'];
            });
            if (defined("$modelClass::ADDITIONAL_PERMISSIONS")) {
                foreach ($modelClass::ADDITIONAL_PERMISSIONS as $customModel => $additionalPermission) {
                    if ($model === "Permission")
                    {
                        foreach ($additionalPermission as $permission) {
                            $perm = $permission . Str::lower(implode('_', preg_split('/(?=[A-Z])/', $customModel)));
                            self::$permissions[] = ['name' => $perm, 'model' => $customModel, 'guard_name'=>'sanctum'];
                        }
                    }else{
                        self::$permissions[] = ['name' => $additionalPermission, 'model' => $model,'guard_name'=>'sanctum'];
                    }
                }
            }


            if (defined("{$modelClass}::ADDITIONAL_OTHER_PERMISSIONS")) {
                foreach ($modelClass::ADDITIONAL_OTHER_PERMISSIONS as $key=> $additionalPermission) {
                    foreach ($additionalPermission as $perm){
                        self::$permissions[] = ['name' => $perm, 'model' => $key,'guard_name'=>'sanctum'];
                    }
                }
            }

        });
        return self::$permissions;
    }
}
