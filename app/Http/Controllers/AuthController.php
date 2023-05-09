<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function register(Request $request): Application|ResponseFactory|\Illuminate\Foundation\Application|Response
    {
        $fields = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|unique:users,email',
            'password' => 'required'
        ]);

        $user = User::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('api-currency')->plainTextToken;

        $response = [
            'user'  => 'Hello' . $user->name,
            'token' => $token,
        ];

        return response($response, 201);
    }

    /**
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function logout(): Application|ResponseFactory|\Illuminate\Foundation\Application|Response
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'Logged out'], 200);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function login(Request $request): Application|ResponseFactory|\Illuminate\Foundation\Application|Response
    {
        $fields = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Bad creds'], 401);
        }

        $token = $user->createToken('api-currency')->plainTextToken;

        $response = [
            'user'  => 'Hello ' . $user->name,
            'token' => $token,
        ];

        return response($response, 201);
    }
}
