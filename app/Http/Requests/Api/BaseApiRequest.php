<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class BaseApiRequest extends FormRequest
{
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
     * @param Validator $validator
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        if (\Request::wantsJson()) {
            $errors = $validator->errors();
            throw new HttpResponseException(response()->json([
                'status' => 422,
                'message' => __('The given data was invalid'),
                'errors' => $errors,
            ], Response::HTTP_UNPROCESSABLE_ENTITY));
        } else {
            Parent::failedValidation($validator);
        }
    }
}
