<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ResumeService {
    
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
}