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
        $data['user_id'] = Auth::user()->id;
        
        if(isset($data['id'])) {
            

        }else {
            return Contact::create($data);
        }
    }
}