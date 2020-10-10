<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserType;
use App\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->input(['id']);
        $user = UserType::where('id', '=', $credentials)->first();
  
        if (!$token = JWTAuth::fromUser($user)) {
            return response('Invalid Login Details', 400)
                ->header('Content-Type', 'text/plain');
        }
        return response($token, 200)
                ->header('Content-Type', 'text/plain');
    }

    public function register(Request $request)
    {
        $role = Role::find($request->input(['role_id']));
        if($role){
            $userType = new UserType;
            $userType->role()->associate($role)->save();
            $token = JWTAuth::fromUser($userType);
            return response($token, 201)
                    ->header('Content-Type', 'text/plain');
        }
        return response('Invalid Role id', 400)
        ->header('Content-Type', 'text/plain');
    }
    
}
