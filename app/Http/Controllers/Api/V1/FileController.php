<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Repositories\Contracts\FileContract;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group files
 */
class FileController extends BaseApiController
{
    /**
     * UserController constructor.
     * @param FileContract $repository
     */
    public function __construct(FileContract $repository)
    {
        parent::__construct($repository, FileResource::class);
    }

    /**
     * Upload new file
     *
     * @bodyParam file required The uploaded file.
     * @bodyParam type string required The file type. (meeting attachment -> request_meeting_attachment)
     * <p>Available types:</p>
     * <p><code>user_avatar => To upload user avatar</code></p>
     *
     * @param FileRequest $request
     * @return JsonResponse
     *
     * @unauthenticated
     */
    public function store(FileRequest $request): JsonResponse
    {
        try {
            $uploaded = $this->repository->saveUploads($request);
            if (is_array($uploaded)) {
                return $this->respondWithCollection($uploaded);
            }
            if (!empty($uploaded)) {
                return $this->respondWithModel($uploaded);
            }
            return $this->respondWithError(__('something went wrong when upload files'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * Delete File
     *
     * @param $id
     * @return JsonResponse
     *
     * @unauthenticated
     */
    public function destroy($id): JsonResponse
    {
        try{
            $file = File::findOrFail($id);
            $this->repository->remove($file);
            return $this->respondWithSuccess(__('file deleted successfully'));
        }catch(\Exception $e) {
            return $this->respondWithError(__('something went wrong when upload files'));
        }
    }

}
