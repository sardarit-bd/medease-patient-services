<?php

namespace App\Modules\Medications\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TakeMedicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schedule_id' => ['required', 'uuid', 'exists:medication_schedule,id'],
            'status'      => ['required', 'in:taken,missed,delayed,skipped'],
            'notes'       => ['sometimes', 'nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'schedule_id.exists' => 'Medication schedule not found.',
            'status.in'          => 'Status must be one of: taken, missed, delayed, skipped.',
        ];
    }
}