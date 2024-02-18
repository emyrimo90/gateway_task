<?php

namespace App\Repositories\SQL;

use App\Models\File;
use App\Repositories\Contracts\FileContract;
use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;

class FileRepository extends BaseRepository implements FileContract
{

    use FileUploadTrait;

    /**
     * FileRepository constructor.
     * @param File $model
     */
    public function __construct(File $model)
    {
        parent::__construct($model);
    }

    public function saveUploads($request): bool|File|array|null
    {
        $file = $request->file('attachment');
        if ($request->hasFile('attachment') && !is_array($request->file('attachment'))){
            $uploaded = $this->upload($file, $request->type);
        }elseif($request->hasFile('attachment') && is_array($request->file('attachment'))){
            $uploaded = $this->uploadMany($file, $request->type);
        }else{
            $uploaded = null;
        }
        return $uploaded;
    }

    public function remove(Model $model, bool $deleteDefinedRelations = false): bool
    {
        return $this->deleteFile($model);
    }

}
