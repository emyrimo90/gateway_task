<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Role;
use App\Models\User;
use \Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\V1\UserRequest;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\UserContract;
use App\Http\Controllers\Api\BaseApiController;


class UserController extends BaseApiController
{
    /**
     * UserController constructor.
     * @param UserContract $repository
     */
    public function __construct(UserContract $repository)
    {
        parent::__construct($repository, UserResource::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     *
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->repository->create($request->validated());
        return $this->respondWithModel($user->load($this->relations));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return mixed
     */
    public function show(User $user): mixed
    {
        return $this->respondWithModel($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return mixed
     */
    public function update(UserRequest $request, User $user): mixed
    {
        $user = $this->repository->update($user, $request->validated());
        return $this->respondWithModel($user->load($this->relations));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->repository->remove($user);
        return $this->respondWithSuccess(__('User Deleted Successfully'));
    }
}
