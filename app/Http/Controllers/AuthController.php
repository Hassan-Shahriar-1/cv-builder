<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth routes
 * @unauthenticated
 */
class AuthController extends Controller
{
    public function __construct( private UserService $userService)
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
        
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $msg = '';
                $status = true;
                $code = 200;
                $accessToken = $user->createToken('cv builder login token')->accessToken;
                $refreshToken = $user->createToken('cv builder login token', ['refresh_token'])->accessToken;

                $data = [
                        'access_token' => $accessToken,
                        'token_type' => 'Bearer',
                        'expires_at' => now()->addHours(1),
                        'refresh_token' =>  $refreshToken
                    ];
            } else {
                $msg = 'Wrong Credentails';
                $data = [];
            }
            return ApiResponseHelper::otherResponse($status, $code, $msg, $data, 200);
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }
}
