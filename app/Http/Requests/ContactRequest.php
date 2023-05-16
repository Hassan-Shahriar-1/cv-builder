<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'sometimes|required|exists:contacts,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'job_title' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'linkedin_link' => 'sometimes|nullable|string|max:255',
            'facebook_link' => 'sometimes|nullable|string|max:255',
            'twitter_link' => 'sometimes|nullable|string|max:255',
            'website' => 'sometimes|nullable|string|max:255',
            'image' => 'nullable|image|max:2000',
            
        ];
    }
}
