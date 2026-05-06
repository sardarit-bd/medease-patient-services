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

            'first_name'               => ['sometimes', 'string', 'max:100'],
            'last_name'                => ['sometimes', 'string', 'max:100'],
            'date_of_birth'            => ['sometimes', 'nullable', 'date'],
            'gender'                   => ['sometimes', 'nullable', 'in:male,female,other,prefer_not_to_say'],
            'nationality'              => ['sometimes', 'nullable', 'string', 'max:100'],
            'language'                 => ['sometimes', 'nullable', 'string', 'max:100'],
            'phone'                    => ['sometimes', 'nullable', 'string', 'max:30'],
            'email'                    => ['sometimes', 'nullable', 'email', 'max:255'],
            'address'                  => ['sometimes', 'nullable', 'string'],
            'city'                     => ['sometimes', 'nullable', 'string', 'max:100'],
            'postal_code'              => ['sometimes', 'nullable', 'string', 'max:20'],
            'country'                  => ['sometimes', 'nullable', 'string', 'max:100'],
            'blood_group'              => ['sometimes', 'nullable', 'string', 'in:A+,B+,AB+,O+,A-,B-,AB-,O-,unknown'],
            'height_cm'                => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:300'],
            'weight_kg'                => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:500'],
            'imc'                      => ['sometimes', 'nullable', 'integer'],
            'dob_of_height_and_weight' => ['sometimes', 'nullable', 'date'],
            'profile_completed'        => ['sometimes', 'nullable', 'boolean'],
        ];
    }

    public function toArray(): array
    {
        $data = [
            'first_name'               => $this->first_name,
            'last_name'                => $this->last_name,
            'date_of_birth'            => $this->date_of_birth,
            'gender'                   => $this->gender,
            'nationality'              => $this->nationality,
            'language'                 => $this->language,
            'phone'                    => $this->phone,
            'email'                    => $this->email,
            'address'                  => $this->address,
            'city'                     => $this->city,
            'postal_code'              => $this->postal_code,
            'country'                  => $this->country,
            'blood_type'               => $this->blood_type,
            'blood_group'              => $this->blood_group,
            'height_cm'                => $this->height_cm,
            'weight_kg'                => $this->weight_kg,
            'imc'                      => $this->imc,
            'dob_of_height_and_weight' => $this->dob_of_height_and_weight,
            'profile_completed'        => $this->profile_completed,
        ];
        return array_filter($data, fn($value) => !is_null($value));
    }
}
