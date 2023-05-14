<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    public function expectsJson()
    {
        return true;
    }

    public function wantsJson()
    {
        return true;
    }
    protected function failedValidation(Validator $validator) 
    {

        throw new HttpResponseException(
            response()->json([
                'status'       => false,
                'status_code' => 400,
                'message'   => $validator->errors()->first(),
                'errors'    => $validator->errors(),
                'data'   => []
            ],422)
        );        
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
}
