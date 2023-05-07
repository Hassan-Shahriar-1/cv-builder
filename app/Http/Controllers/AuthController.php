<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserResource;
use App\Services\userService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private userService $userService)
    {
        
    }
    /**
     * User Registration
     * @param SignupRequest $request
     * @return JsonResponse
     */
    public function signup(SignupRequest $request): JsonResponse
    {
        $requestData = $request->all();
        $requestData['user_type'] = $this->userService::USER_ROLE;
        DB::beginTransaction();
        try{
            $user = new UserResource($this->userService->createUser($requestData));
            DB::commit();
            return ApiResponseHelper::otherResponse(true, 200, 'created', $user, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError($e);
        }
    }

    /**
     * Login
     * @param
     * @return JsonResponse
     */
    public function login(LoginRequest $request) :JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $status = false;
        $code = 400;
        try{
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $msg = '';
                    $status = true;
                    $code = 200;
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $data = ['token' => $token];
               
                } else {
                    $msg = 'Password mismatch';
                    $data = [];
                }
            } else {
                $msg = 'User does not exist';
                $data = [];
            }
            return ApiResponseHelper::otherResponse($status, $code, $msg, $data, 200);
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }
}
