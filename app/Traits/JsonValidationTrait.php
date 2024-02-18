<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait JsonValidationTrait
{
    protected function failedValidation(Validator $validator): void
    {
        if (Request::wantsJson()) {
            $errors = $validator->errors();
            throw new HttpResponseException(response()->json([
                'status' => 422,
                'message' => __('The given data was invalid'),
                'errors' => $errors,
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY));
        }
        parent::failedValidation($validator);
    }
}
