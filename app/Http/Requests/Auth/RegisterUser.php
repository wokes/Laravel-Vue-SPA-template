<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
{
    public function rules()
    {
        return [
            'id'        => 'required|uuid|unique:users',
            'name'      => 'required|string|max:255|unique:users',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|string|max:255',
        ];
    }
}
