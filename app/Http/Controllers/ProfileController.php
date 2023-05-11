<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Profile 
 * @group Profile
 * @authenticated
 */
class ProfileController extends Controller
{
    /**
     * Get Profile Data
     * @return JsonResponse
     */
    public function getProfileData()
    {
        $user = Auth::user();
        return ApiResponseHelper::otherResponse(true, 200, '', new ProfileResource($user), 200);
    }

    /**
     * Update Profile
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     * @param UserService $userService
     */
    public function updateProfile(UpdateProfileRequest $request, UserService $userService)
    {
        $data = $request->validated();
        try{
            $userService->updateProfile($data);
            return ApiResponseHelper::otherResponse(true, 200, trans('messages.profile-update'),[],201);
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }

    }
}
