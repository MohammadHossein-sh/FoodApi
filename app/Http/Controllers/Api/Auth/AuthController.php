<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|regex:/^[\p{L}\p{N}]+$/u',
            'last_name' => 'required|string|regex:/^[\p{L}\p{N}]+$/u',
            'email' => 'required|string|regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/|unique:users,email',
            'password' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/',
            'c_password' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        DB::beginTransaction();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        DB::commit();

        $token = $user->createToken('myApp')->plainTextToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            'password' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->errorResponse('user not found', 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return $this->errorResponse('email or password is incorrect', 401);
        }
        $token = $user->createToken('myApp')->plainTextToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token,
        ], 200);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse(null,200,'logout success');
    }
}
