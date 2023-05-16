<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\ExperienceRequest;
use App\Http\Requests\ObjectiveRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\SkillRequest;
use App\Http\Resources\EducationResouce;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\ObjectiveResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SkillResource;
use App\Models\CareerObjective;
use App\Models\Media;
use App\Models\Project;
use App\Models\Skill;
use App\Models\WorkExperience;
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

            //cv media image upload or update
            if($request->has('image')) {
                $storagePath = Media::uploadImage($request->file('image'), 'cv-image');
                
                if($contactData->media){
                    
                    Media::removeFile($contactData->media->photo, config('settings.media.disc'));
                    $contactData->media->update(['photo' => $storagePath]);
                }else{
                    $contactData->media()->create(['photo' => $storagePath]);
                }
            }
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

    /**
     * create or update project
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function project(ProjectRequest $request) :JsonResponse
    {
        $projectRequestData = $request->validated();
        try{
            $projectData = $this->resumeService->createOrUpdateProject($projectRequestData);
            return ApiResponseHelper::otherResponse(true, 200, '', new ProjectResource($projectData), 201);
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }

    /**
     * Delete project
     * @param string $projectId
     * @return JsonResponse
     */
    public function deleteProject(string $projectId) :JsonResponse
    {
        try{
            $project = Project::where('id', $projectId)->first();
            if($project) {
                $project->delete();
                return ApiResponseHelper::otherResponse(true, 200, trans('messages.delete'), [], 204);
            }else{
                return ApiResponseHelper::errorResponse(trans('messages.404'));
            }
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }

    /**
     * create & update experience
     * @param ExperienceRequest $request
     * @return JsonResponse
     */
    public function experience(ExperienceRequest $request) :JsonResponse
    {
        $experienceRequestData = $request->validated();
        try{
            $experienceData = $this->resumeService->createOrUpdateExperience($experienceRequestData);
            return ApiResponseHelper::otherResponse(true, 200, trans('messages.created'), new ExperienceResource($experienceData), 201);
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }

    /**
     * Delete Experience
     * @param WorkExperience $experience
     * @return JsonResponse
     */
    public function deleteExperiece(WorkExperience $experience) :JsonResponse
    {
        try{
            $experience->delete();            
            return ApiResponseHelper::otherResponse(true, 200, trans('messages.delete'), [], 201);
        } catch (Exception $e) {
            return ApiResponseHelper::serverError($e);
        }
    }

}
