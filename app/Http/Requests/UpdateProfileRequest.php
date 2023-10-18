<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
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
    public function rules(): array
    {
        return [
            'first_name' => 'string',
            'middle_name' => 'string',
            'last_name' => 'string',
            'mobile_number' => 'string',
            'avatar' => 'string',
            'cover' => 'string',
            'is_private' => 'string',
            'language' => 'string',
            'currency' => 'string',
            'timezone' => 'string',
            'calendar' => 'string',
            'shortcuts' => 'string',
            'layout' => 'string',
            'latitude' => 'string',
            'longitude' => 'string',
        ];
    }
}
