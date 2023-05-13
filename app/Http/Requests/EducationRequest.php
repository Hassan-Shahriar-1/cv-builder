<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'sometimes|nullable|exists:educations,id',
            'name' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'location' => 'sometimes|nullable|String|max:255',
            'feild_of_study' => 'sometimes|nullable|string|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'sometimes|nullable|date_format:Y-m-d',
        ];
    }
}
