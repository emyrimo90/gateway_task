<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseApiController;

class TokenController extends BaseApiController
{
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required','email','max:150',Rule::exists('users')],
            'password' => ['required','max:100'],
        ]);
        $user = User::whereEmail($credentials['email'])->first();
        if (!$this->userCanLogin($user, $credentials['password'])) {
            return $this->respondWithError(trans('api.invalid_credentials'));
        }
        $token = $this->generateToken($user, 'access_token');
        return response()->json([
            'status' => 200,
            'token'  => $token,
            'user'   => new UserResource($user),
        ]);
    }

    protected function generateToken($user, $name)
    {
        $user->tokens()->delete();
        return $user->createToken($name)->plainTextToken;
    }

    protected function userCanLogin($user, $password): bool
    {
        return $user and Hash::check($password, $user->password);
    }
}
