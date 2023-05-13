<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Education;
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

}