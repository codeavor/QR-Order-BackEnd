<?php

namespace Tests\Feature\Apis;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Models\UserType;
use App\Models\Role;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $role =  Role::factory()->create();
        
        $data = [
            'role_name' => $role->name,
            'umbrella_id' => 2
        ];

       // fwrite(STDERR, print_r($data, TRUE));

        $this->json('POST', route('api_register'),$data)
        ->assertStatus(201);

        $data = [
            'role_name'=> '',
            'umbrella_id' => 1
        ];

        $this->json('POST', route('api_register'),$data)
        ->assertStatus(401);

        $data = [
            'role_name'=> $role->name,
        ];

        $this->json('POST', route('api_register'),$data)
        ->assertStatus(401);

        $data = [
            'role_name'=> 'assdsd',
            'umbrella_id' => 1
        ];

        $this->json('POST', route('api_register'),$data)
        ->assertStatus(401);
    }

    public function testLogin()
    {
        $role =  Role::factory()->create();
        $userType = new UserType;

        $userType->role()->associate($role)->save();

        $data = [
            'id'=> $userType->id
        ];

        $this->json('POST', route('api_login'),$data)
        ->assertStatus(200);

        $id = $userType->id + 1;

        $data = [
            'id'=> $id
        ];

        $this->json('POST', route('api_login'),$data)
        ->assertStatus(500);        
    }

    public function testGetToken()
    {

        try { 
            $role =  Role::factory()->create();
            $userType = new UserType;
            $userType->role()->associate($role)->save();
            $token = JWTAuth::fromUser($userType);
        } catch (JWTException $e) {
            return 'could_not_create_token';
        }
       
        $this->withHeaders(['Authorization' => 'Bearer ' . $token])->json('POST', route('api_refresh'))
        ->assertStatus(201);
    }
}
