<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Resources\ProfileResource;
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
}
