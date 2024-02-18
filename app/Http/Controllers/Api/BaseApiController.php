<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BaseContract;
use App\Services\Payments\Paypal;
use App\Traits\BaseApiResponseTrait;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BaseApiController extends Controller
{
    use BaseApiResponseTrait;
    protected bool $order = true;
    protected $orderBy = 'id';
    protected BaseContract $repository;
    protected mixed $modelResource;
    protected array $relations = [];

    /**
     * BaseApiController constructor.
     *
     * @param BaseContract $repository
     * @param mixed $modelResource
     */
    public function __construct(BaseContract $repository, mixed $modelResource)
    {
        $this->repository = $repository;
        $this->modelResource = $modelResource;

        // Include embedded data
        if (request()->has('embed')&& !empty(request()->get('embed'))) {
            $this->parseIncludes(request('embed'));
        }
    }

    /**
     * index() Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(): mixed
    {
        $page = 1;
        $limit = 10;
        $order = $this->order;
        $orderBy = $this->orderBy;
        $orderDir = 'desc';
        $simplePaginate = false;
        $filters = request()->all();
        if (request()->has('page')) {
            $page = request('page');
        }
        if (request()->has('limit')) {
            $limit = request('limit');
        }
        if (request()->has('order')) {
            $order = request('order');
        }
        if (request()->has('orderBy')) {
            $orderBy = request('orderBy');
        }
        if (request()->has('orderDir')) {
            $orderDir = request('orderDir');
        }
        if (request()->has('simplePaginate')) {
            $simplePaginate = request('simplePaginate');
        }
        $models = $this->repository->search($filters, $this->relations, $order,
            $page, $limit, $orderBy, $orderDir, [], false, null, null, null, $simplePaginate);
        return $this->respondWithCollection($models);
    }


    /**
     * parseIncludes() used to explode embed relations array
     *
     * @param $embed
     */
    protected function parseIncludes($embed): void
    {
        $this->relations = explode(',', $embed);
    }

    /**
     * respond() used to return resource with status and headers
     *
     * @param $resources
     * @param array $headers
     * @param array $additional
     * @return mixed
     */
    protected function respond($resources, array $headers = [], array $additional = []): mixed
    {
        return $resources
            ->additional(array_merge(['status' => $this->getStatusCode()], $additional))
            ->response()
            ->setStatusCode($this->getStatusCode())
            ->withHeaders($headers);
    }

    /**
     * respondWithCollection() used to take collection
     * and return its data transformed by resource response
     *
     * @param $collection
     * @param int|null $statusCode
     * @param array $headers
     * @param array $additional
     * @return mixed
     */
    protected function respondWithCollection($collection, int $statusCode = null, array $headers = [], array $additional = []): mixed
    {
        $statusCode = $statusCode ?? ResponseAlias::HTTP_OK;
        $resources = forward_static_call([$this->modelResource, 'collection'], $collection);
        return $this->setStatusCode($statusCode)->respond($resources, $headers, $additional);
    }

    /**
     * respondWithModel() used to return result with one model relation
     *
     * @param $model
     * @param int|null $statusCode
     * @param array $headers
     * @return mixed
     */
    protected function respondWithModel($model, int $statusCode = null, array $headers = []): mixed
    {
        $statusCode = $statusCode ?? ResponseAlias::HTTP_OK;
        $resource = new $this->modelResource($model->load($this->relations));
        return $this->setStatusCode($statusCode)->respond($resource, $headers);
    }

}
