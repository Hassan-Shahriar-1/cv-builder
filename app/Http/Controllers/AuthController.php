<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Services\userService;
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
        
    }
}
