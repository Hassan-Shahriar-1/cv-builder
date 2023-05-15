<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\ObjectiveRequest;
use App\Http\Requests\SkillRequest;
use App\Http\Resources\EducationResouce;
use App\Http\Resources\ObjectiveResource;
use App\Http\Resources\SkillResource;
use App\Models\CareerObjective;
use App\Models\Skill;
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

    /**
     * create or update education
     * @param EducationRequest $request
     * @return JsonResponse
     */
    public function education(EducationRequest $request) : JsonResponse
    {
        $data = $request->validated();
        try{
            $educationData = $this->resumeService->createOrUpdateEducation($data);
            
            return ApiResponseHelper::otherResponse(true, 200, '', new EducationResouce($educationData),201);           
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }

    }

    /**
     * Skills create or update
     * @param SkillRequest $request
     * @return JsonResponse
     */
    public function skills(SkillRequest $request): JsonResponse
    {
        $skills = $request->validated();
        $msg = '';
        $data = [];
        try{
            if(!empty($skills)){
                $data = $this->resumeService->createOrUpdateSkills($skills);
                $msg = trans('messages.created');
            }

            return ApiResponseHelper::otherResponse(true, 200, $msg, SkillResource::collection($data), 201);

        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }

    /**
     * Delete skill
     * @param string $skillId
     * @return JsonResponse
     */
    public function deleteSkill(string $skillId) :JsonResponse
    {
        try{
            $check = Skill::where('id', $skillId)->first();
            if($check) {
                $check->delete();
                return ApiResponseHelper::otherResponse(true, 200, trans('messages.delete'), [], 201);
            } else {
                return ApiResponseHelper::otherResponse(false, 400, trans('messages.404'), [], 201);
            }

        }catch(Exception $e){
            return ApiResponseHelper::serverError($e);
        }

    }

    /**
     * create or update objective
     * @param ObjectiveRequest $request
     * @return JsonResponse
     */
    public function crareerObjective(ObjectiveRequest $request) :JsonResponse
    {
        $objectiveData = $request->validated();
        
           $checker =  CareerObjective::where('user_id', Auth::user()->id)->first();
           if($checker && (isset($objectiveData['id']) == null || $objectiveData['id'] == null)) {
                return ApiResponseHelper::errorResponse(trans('messages.integrity_message'));
           }
        
        try{
            $data = $this->resumeService->createOrUpdateObjective($objectiveData);
            return ApiResponseHelper::otherResponse(true, 200, '', new ObjectiveResource($data), 201);
        } catch(Exception $e){
            return ApiResponseHelper::serverError($e);
        }

    }
}
