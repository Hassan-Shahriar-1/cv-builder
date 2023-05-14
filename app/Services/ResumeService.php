<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Education;
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
        $educationData['user_id'] = Auth::user()->id;

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
        $userId = Auth::user()->id;
        $updateData = [];
        foreach($skills as $skill) {
            // updating skills
            if(isset($skill['id']) && $skill['id'] != null) {
                $data = Skill::where('id', $skill['id'])->first();
                unset($skill['id']);
                $data->update($skill);
                $updateData [] = $data;
            } else{
                $skill['user_id'] = $userId;
                $updateData [] = Skill::create($skill);
            }
        }
        return $updateData;
    }

}