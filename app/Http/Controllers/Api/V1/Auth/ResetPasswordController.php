<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Resources\UserResource;
use App\Repositories\SQL\UserRepository;
use App\Traits\BaseApiResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use BaseApiResponseTrait;
    public function __invoke(Request $request)
    {
       $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = app(UserRepository::class)->findBy('email', $request->email);
        $user->update(['password'=> $request->password]);

        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return $this->respondWithSuccess(__('password_changed_successfully'), [
                'user' => new UserResource($request->user()->load('roles', 'permissions')),
            ]);
        }
        return $this->errorWrongArgs('Wrong Credentials');

    }
}
