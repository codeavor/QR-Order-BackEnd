<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserType;
use App\Models\Role;
use App\Models\Order;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->input(['id']);
        $user = UserType::where('id', '=', $credentials)->first();
  
        try {
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
            'umbrella_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        
        $role = Role::where('name', $request->input(['role_name']))->first();
        if($role){
            $userType = new UserType;
            $userType->role()->associate($role)->save();
            try { 
                $token = JWTAuth::fromUser($userType);
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            $order = Order::create([
                'umbrella_id' => $request->input(['umbrella_id']),
                'order_complete' => false
            ]);
            $order->userType()->associate($userType);
            $order->save();

            return response()->json(compact(['token', 'order']), 201);
        }
        return response()->json(['error'=>'Invalid Login Details'], 401);
    }

    // Refresh Token 
    public function getToken(Request $request)
     {
        if(!$token = JWTAuth::parseToken()){
            throw new BadRequestHtttpException('Token not provided');
        }
        try{
            $refreshedToken = JWTAuth::refresh($token);
        }catch(JWTException $e){
            return response()->json(['Error' => 'could_not_refresh_token'], 500);
        }
        return response()->json(compact('refreshedToken'), 201);
    }
    
}
