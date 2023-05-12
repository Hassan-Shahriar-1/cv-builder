<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\ContactRequest;
use App\Services\ResumeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Resume
 */
class ResumeController extends Controller
{
    public function __construct(private ResumeService $resumeService)
    {
        
    }
    /**
     * create or update contact
     * @param ContactRequest $request
     * @return JsonResponse
     */
    public function contact(ContactRequest $request) : JsonResponse
    {
        $data = $request->validated();
        try{
            $contactData = $this->resumeService->createOrUpdateContact($data);
            return ApiResponseHelper::otherResponse(true, 200, '', $contactData, 201);
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }
}
