<?php

namespace App\Modules\Auth\Requests;

use App\Http\Requests\BaseRequest;

class VerifyEmailRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['required']
        ];
    }
}
