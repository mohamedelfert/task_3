<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,35',
            'last_name' => 'required|string|between:2,35',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

        $data = $request->except(['password']);
        $data['password'] = bcrypt($request->password);

        $user = User::create($data);
        $user->attachRole('admin');

        return response()->json(
            [
                'status' => true,
                'message' => 'User successfully registered',
                'user' => $user,
            ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->messages()
            ), 400);
        }

        //Request is validated
        //Create token
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Login credentials are invalid.',
                    ], 400);
            }
        } catch (JWTException $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Could not create token.',
                ], 500);
        }

        //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ], 200);
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(array(
            "status" => true,
            "message" => 'User Logout successfully'
        ), 200);
    }

    public function profile(Request $request)
    {
        $response = [
            'status' => true,
            'message' => 'profile',
            'user' => auth()->user(),
        ];
        return response()->json($response, 200);
    }
}
