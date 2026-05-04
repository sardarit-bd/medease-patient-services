<?php

namespace App\Modules\User\Requests;

use App\Http\Requests\BaseRequest;

class UploadPhotoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}