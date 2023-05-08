<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Sending reset password link
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function sendResetLinkEmail(PasswordResetRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $response = $this->broker()->sendResetLink(
            $data['email']
        );

        return $response == Password::RESET_LINK_SENT
                    ? ApiResponseHelper::otherResponse(true, 200, trans('messages.password_reset_link'), [], 200)
                    : ApiResponseHelper::errorResponse(trans('messages.reset_link_failed'));
    }

    
    /**
     * password broker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
