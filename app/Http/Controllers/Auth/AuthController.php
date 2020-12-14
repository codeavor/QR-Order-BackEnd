<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            return response()->json(['error' => $validator->errors()], 401);
        }

        $credentials = $request->input(['id']);
        $user = UserType::where('id', '=', $credentials)->first();
  
        // try {
        //     if (!$token = JWTAuth::fromUser($user)) {
        //         return response()->json(['error' => 'invalid_credentials'], 401);
        //     }
        // } catch (JWTException $e) {
        //     return response()->json(['error' => 'could_not_create_token'], 500);
        // }

        if (!$user) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $token = auth()->login($user);

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $role = '';
        $validator = Validator::make($request->all(), [
            'umbrella_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        if ($request->input(['umbrella_id']) > 0){
            $role = 'customer';
        }elseif ($request->input(['umbrella_id']) == 0){
            $role = 'kitchen';
        }else{
            return response()->json(['error'=>'Invalid Umbrella id'], 401);
        }
        $role = Role::where('name', $role)->first();
        if($role){
            $userType = new UserType;
            $userType->role()->associate($role)->save();
            // try { 
            //     $token = JWTAuth::fromUser($userType);
            // } catch (JWTException $e) {
            //     return response()->json(['error' => 'could_not_create_token'], 500);
            // }
            $token = auth()->login($userType);

            $order = Order::create([
                'umbrella_id' => $request->input(['umbrella_id']),
            ]);
            $order->userType()->associate($userType);
            $order->save();

            $orderId = $order->id;

            return response()->json(compact(['token', 'orderId','role']), 201);
        }
        return response()->json(['error'=>'Invalid Login Details'], 401);
    }

    // Refresh Token 
    public function getToken()
     {
        if(!$token = JWTAuth::parseToken()){
            throw new BadRequestHtttpException('Token not provided');
        }
        try{
            $refreshedToken = JWTAuth::refresh($token);
        }catch(JWTException $e){
            return response()->json(['error' => 'could_not_refresh_token'], 500);
        }
        return response()->json(compact('refreshedToken'), 201);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    
}
