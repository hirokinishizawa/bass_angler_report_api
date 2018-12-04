<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    public function user()
    {
        $users = DB::table('users')->get();

        return view('user.index', ['users' => $users]);
    }
}
