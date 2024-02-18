<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\JsonValidationTrait;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use JsonValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|min:2|max:200',
            'email' => ['required', 'email'],
            'password' => [
                'string',
                'min:8', // must be at least 8 characters in length
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'password_confirmation' => ['same:password'],
            'phone' => "required|numeric|digits:10|unique:users,phone,{$this->id}",
            'role_id' => 'required|exists:roles,id',
            'segment_ids' => 'nullable|array',
            'segment_ids.*' => 'nullable|exists:segments,id',
            'sub_segment_ids' => 'nullable|array',
            'sub_segment_ids.*' => 'nullable|exists:segments,id',
            'warehouse_ids' => 'nullable|array',
            'warehouse_ids.*' => 'nullable|exists:warehouses,id'
        ];
        if ($this->method() === 'POST'){
            $rules['password'][] = 'required';
            $rules['password_confirmation'][] = 'required';
            $rules['email'][] = Rule::unique('users', 'email')->ignore($this->email)->whereNull('deleted_at');
        }else{
            $rules['password'][] = 'nullable';
            $rules['password_confirmation'][] = 'nullable';
            $rules['email'][] = "unique:users,email,{$this->id}";
        }
        return $rules;
    }

    /**
     * Customizing input names displayed for user
     * @return array
     */
    public function attributes(): array
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }
}
