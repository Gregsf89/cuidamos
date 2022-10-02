<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Validator;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make(
            $credentials,
            [
                'email' => 'required|email:rfc,dns',
                'password' => 'required|string|min:6'
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        return (new AuthService())->login($credentials);
    }

    protected function create(Request $request)
    {
        $credentials = $request->only(['email', 'password', 'password_confirmation']);

        $validator = Validator::make(
            $credentials,
            [
                'email' => 'required|email:rfc,dns',
                'password' => 'required|string|regex:^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^', //Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character
                'password_confirmation' => 'required|same:password'
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100002);
        }

        return (new AuthService())->create($credentials);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
