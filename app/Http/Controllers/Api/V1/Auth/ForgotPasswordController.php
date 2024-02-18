<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    /**
     *
     */
    use SendsPasswordResetEmails;
    public function __invoke(Request $request)
    {
        $requests = $request->validate([
            'email'    => 'required|email|exists:users',
        ]);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
