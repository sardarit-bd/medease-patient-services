<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'first_name' => ['sometimes', 'string', 'max:100'],
            'last_name' => ['sometimes', 'string', 'max:100'],
            'date_of_birth' => ['sometimes', 'date'],
            'gender' => ['sometimes', 'in:male,female,other,prefer_not_to_say'],
            'blood_type' => ['sometimes', 'string', 'max:5'],
            'height' => ['sometimes', 'numeric', 'min:0', 'max:300'],
            'weight' => ['sometimes', 'numeric', 'min:0', 'max:500'],
            'social_security_number' => ['sometimes', 'string', 'max:50'],
            'address' => ['sometimes', 'string'],
            'city' => ['sometimes', 'string', 'max:100'],
            'postal_code' => ['sometimes', 'string', 'max:20'],
            'country' => ['sometimes', 'string', 'max:100'],
            'phone' => ['sometimes', 'string', 'max:20'],
        ];
    }
}
