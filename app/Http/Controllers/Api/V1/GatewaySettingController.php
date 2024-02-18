<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\GatewaySetting;
use \Illuminate\Http\JsonResponse;
use App\Http\Resources\GatewaySettingResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\GatewaySettingRequest;
use App\Repositories\Contracts\GatewaySettingContract;

class GatewaySettingController extends BaseApiController
{
    /**
     * GatewaySettingController constructor.
     * @param GatewaySettingContract $repository
     */
    public function __construct(GatewaySettingContract $repository)
    {
        parent::__construct($repository, GatewaySettingResource::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GatewaySettingRequest $request
     *
     * @return JsonResponse
     */
    public function store(GatewaySettingRequest $request): JsonResponse
    {
        $gatewaySetting = $this->repository->create($request->validated());
        return $this->respondWithModel($gatewaySetting);
    }

    /**
     * Display the specified resource.
     *
     * @param GatewaySetting $gatewaySetting
     * @return mixed
     */
    public function show(GatewaySetting $gatewaySetting): mixed
    {
        return $this->respondWithModel($gatewaySetting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GatewaySettingRequest $request
     * @param GatewaySetting $gatewaySetting
     * @return mixed
     */
    public function update(GatewaySettingRequest $request, GatewaySetting $gatewaySetting): mixed
    {
        $gatewaySetting = $this->repository->update($gatewaySetting, $request->validated());
        return $this->respondWithModel($gatewaySetting->load($this->relations));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GatewaySetting $gatewaySetting
     *
     * @return JsonResponse
     */
    public function destroy(GatewaySetting $gatewaySetting): JsonResponse
    {
        $this->repository->remove($gatewaySetting);
        return $this->respondWithSuccess(__('GatewaySetting Deleted Successfully'));
    }
    public function changeStatus($id): JsonResponse
    {
        $gatewaySetting = $this->repository->find($id);
        if ($gatewaySetting) {
            $this->repository->updateAllGateways(GatewaySetting::NOT_ACTIVE);
            $gatewaySetting->update(['status' => !$gatewaySetting->status]);
            if($gatewaySetting->status){
                app(GatewaySettingContract::class)->setGatewayNameCookie();
            }
            return $this->respondWithSuccess(__('Update Successfully'), [
                'gatewaySetting' => new GatewaySettingResource($gatewaySetting),
            ]);
        }

        return $this->respondWithError(__('Not found'));
    }
}
