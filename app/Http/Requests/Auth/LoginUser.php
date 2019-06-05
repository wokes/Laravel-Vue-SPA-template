<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginUser extends FormRequest
{
    public function rules()
    {
        return [
            'name'      => 'required|string|max:255',
            'password'  => 'required|string|max:255',
        ];
    }
}
