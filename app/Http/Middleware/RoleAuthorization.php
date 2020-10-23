<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            //Access token from the request        
            $token = JWTAuth::parseToken();
            //Try authenticating user       
            $user = $token->authenticate();
        } catch (TokenExpiredException | TokenInvalidException | JWTException $e) {
            //Thrown if token has expired | token is invalid | there is no token at all       
            return $this->unauthorized($e->getMessage());
        }
        //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
        if ($user && in_array($user->role->name, $roles)) {
            return $next($request);
        }
    
        return $this->unauthorized();
    }

    private function unauthorized($message = null){
        return response()->json([
            'error' => $message ? $message : 'You are unauthorized to access this resource'
        ], 401);
    }
}
