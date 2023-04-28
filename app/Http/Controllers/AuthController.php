<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\SignupRequest;
use App\Services\userService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $requestData = $request->validated();
        $requestData['login_type'] = $this->userService::USER_ROLE;
        try{
            $user = $this->userService->createUser($requestData);
            return ApiResponseHelper::otherResponse(true, 200, 'created', $user, 201);
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }
}
