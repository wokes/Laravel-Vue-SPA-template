<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Auth\RegisterUser;
use App\Http\Requests\Auth\LoginUser;

use Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterUser $request)
    {
        $user = User::create([
            'id'        => $request->input('id'),
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password')),
        ]);

        return response()->json([
            'message'   => 'User registered.',
            'user'      => $user,
            'token'     => $user->createToken('webAccess')->accessToken,
        ], 201);
    }

    public function login(LoginUser $request)
    {
        $passed = Auth::attempt([
            'name'      => $request->input('name'),
            'password'  => $request->input('password'),
        ]);

        if (!$passed)
            return response()->json(['message' => 'Invalid credentials.'], 401);

        $user = Auth::user();

        return [
            'message'   => 'User authenticated.',
            'user'      => $user,
            'token'     => $user->createToken('webAccess')->accessToken,
        ];
    }
}
