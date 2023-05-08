<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\PasswordResetRequest;
use App\Mail\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Sending reset password link
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function sendResetLinkEmail(PasswordResetRequest $request) : JsonResponse
    {

        $user = User::where('email', $request->email)->first();
        //$token = $this->broker()->createToken($user);
        
        $token = $this->broker()->createToken($user);

        if($token)
        {
            Mail::to($user->email)->send(new ResetPassword($token));
            return ApiResponseHelper::otherResponse(true, 200, trans('messages.password_reset_link'), [], 200);
        }else {
            return ApiResponseHelper::errorResponse(trans('messages.reset_link_failed'));
        }
    }

    
    /**
     * password broker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
