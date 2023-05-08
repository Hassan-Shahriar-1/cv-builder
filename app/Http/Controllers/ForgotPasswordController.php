<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Notifications\CustomResetPasswordNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    /**
     * Password reset
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request) :JsonResponse
    {
       

        // Get the credentials from the request
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        // Attempt to reset the password
        $response = Password::reset($credentials, function ($user, $password) {
            // Update the user's password
            $user->password = Hash::make($password);
            $user->save();
        });

        // Check the response from the password broker
        switch ($response) {
            case Password::PASSWORD_RESET:
                return ApiResponseHelper::otherResponse(true, 200, trans('messages.reset_password'), [], 200);
            case Password::INVALID_TOKEN:
                return ApiResponseHelper::errorResponse(trans('messages.invalid_token'));
            case Password::INVALID_USER:
                return ApiResponseHelper::errorResponse(trans('messages.invalid_user'));
            default:
                return ApiResponseHelper::errorResponse(trans('messages.reset_password_problem'));
        }
    }
}
