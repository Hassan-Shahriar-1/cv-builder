<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'skills' => 'sometimes|nullable|array',
            'skills.*.id' => 'somtimes|nullable|exists:skills,id',
            'skills.*.name' => 'required|string|max:255'
        ];
    }
}
