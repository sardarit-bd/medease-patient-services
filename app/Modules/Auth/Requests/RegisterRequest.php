<?php

namespace App\Modules\Auth\Requests;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'role' => ['required', 'in:patient,healthcare_professional,healthcare_facility,Pharmacy,medico_social_establishment,medical_transporter'],
        ];
    }
}