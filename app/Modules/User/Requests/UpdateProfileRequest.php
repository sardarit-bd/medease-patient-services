<?php

namespace App\Modules\User\Requests;

use App\Http\Requests\BaseRequest;

class UpdateProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name'   => ['sometimes', 'string', 'max:100'],
            'last_name'    => ['sometimes', 'string', 'max:100'],
            'date_of_birth'=> ['sometimes', 'date'],
            'gender'       => ['sometimes', 'string', 'in:male,female,other'],
            'blood_type'   => ['sometimes', 'string', 'max:5'],
            'height'       => ['sometimes', 'numeric', 'min:0'],
            'weight'       => ['sometimes', 'numeric', 'min:0'],
            'address'      => ['sometimes', 'string', 'max:255'],
            'city'         => ['sometimes', 'string', 'max:100'],
            'postal_code'  => ['sometimes', 'string', 'max:20'],
            'country'      => ['sometimes', 'string', 'max:100'],
            'phone'        => ['sometimes', 'string', 'max:20'],
        ];
    }
}