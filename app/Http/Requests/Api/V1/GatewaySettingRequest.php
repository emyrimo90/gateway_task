<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\BaseApiRequest;
use App\Rules\CheckGatewayNameRule;
use Illuminate\Validation\Rule;

class GatewaySettingRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
       return [
            'name' => [
                'required',
                'regex:/(*UTF8)^[0-9-A-Za-z]+/',
                'min:2',
                'max:200',
                new CheckGatewayNameRule(),
                Rule::unique('gateway_settings', 'name')->ignore($this->id),
            ],
            'type' => 'required',
            'client_id'=> 'required',
            'client_secret'=>'required',
            'currency' => 'required',
        ];
    }
}
