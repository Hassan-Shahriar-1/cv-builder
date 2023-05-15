<?php

namespace App\Services;

use App\Models\CareerObjective;
use App\Models\Contact;
use App\Models\Education;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class ResumeService 
{    
    /**
     * create or update contact data
     * @param array $data
     * @return object
     */
    public function createOrUpdateContact(array $data) : object
    {
        if(isset($data['id'])) {
            $contact = Contact::findOrFail($data['id']);
            unset($data['user_id'], $data['id']);
            $contact->update($data);
            return $contact;
        }else {
            $data['user_id'] = Auth::user()->id;
            return Contact::create($data);
        }
    }

    /**
     * Education create and update
     * @param $array $educationData
     * @return object
     */
    public function createOrUpdateEducation(array $educationData) : object
    {
        $educationData['user_id'] = $this->getUserId();

        if(isset($educationData['id']))
        {
            $data = Education::where('id', $educationData['id'])->first();
            unset($educationData['id'], $educationData['user_id']);
            $data->update($educationData);
            return $data;
        }else {
            return Education::create($educationData);
        }
    }

    /**
     * create or update skills
     * @param array
     * @return array
     */
    public function createOrUpdateSkills(array $skills) : array
    {
        $userId = $this->getUserId();
        $updateData = [];
        foreach($skills as $skill) {
            // updating skills
            if(isset($skill['id']) && $skill['id'] != null) {
                $data = Skill::where('id', $skill['id'])->first();
                unset($skill['id']);
                $data->update($skill);
                $updateData [] = $data;
            } else{// creating skills
                $skill['user_id'] = $userId;
                $updateData [] = Skill::create($skill);
            }
        }
        return $updateData;
    }

    /**
     * Create or update data of career objective
     * @param array $objectiveData
     * @return object
     */
    public function createOrUpdateObjective(array $objectiveData):object
    {
        if($this->idChecker($objectiveData)) {
            $data = CareerObjective::where('id', $objectiveData['id'])->first();
            unset($objectiveData['id']);
            $data->update($objectiveData);
            return $data;
        } else {
            $objectiveData['user_id'] = $this->getUserId();

           return CareerObjective::create($objectiveData);
        }
    }

    /**
     * ID checker
     * @param array $data
     * @return bool
     */
    public function idChecker(array $data) : bool
    {
        if(isset($data['id']) && $data['id'] != null) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get user Id
     * @return string
     */
    public function getUserId() :string
    {
        return Auth::user()->id;
    }

    /**
     * create & update of Project data
     * @param array $projectData
     * @return object
     */
    public function createOrUpdateProject(array $projectData) :object
    {
        if($this->idChecker($projectData)) {
            $project = Project::where('id', $projectData['id'])->first();
            unset($projectData['id']);
            $project->update($projectData); 
            return $project;
        }else {
            $projectData['user_id'] = $this->getUserId();
            return Project::create($projectData);
        }
    }
}