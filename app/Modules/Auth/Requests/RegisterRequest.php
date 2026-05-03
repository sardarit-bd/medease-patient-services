<?php

namespace App\Modules\Auth\Requests;


use App\Http\Requests\BaseRequest;
class RegisterRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];
    }
}