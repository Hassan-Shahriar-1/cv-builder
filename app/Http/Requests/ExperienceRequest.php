<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' =>'sometimes|nullable|exists:work_experiences,id',
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'active' =>'required|boolean',
            'end_date' => 'sometimes|nullable|date_format:Y-m-d|required_if:active,true',
        ];
    }
}
