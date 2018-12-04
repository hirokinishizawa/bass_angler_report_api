<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'account' => 'required|unique:users|alpha_dash',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'account' => $request->account,
            'password' => bcrypt($request->password)
        ]);

        if(!$token = auth()->attempt($request->only(['account', 'password'])))
        {
            return abort(401);
        }

        return (new UserResource($user))
            ->additional([
                'token' => $token
            ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'account' => 'required',
            'password' => 'required'
        ]);

        if(!$token = auth()->attempt($request->only(['account', 'password'])))
        {
            return response()->json([
                'errors' => [
                    'account' => ['入力情報に誤りがあります']
                ]], 422);
        }

        return (new UserResource($request->user()))
            ->additional([
                'token' => $token
            ]);
    }
}
