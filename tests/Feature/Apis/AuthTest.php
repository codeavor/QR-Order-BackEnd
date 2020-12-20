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
            'umbrella_id' => 0
        ];

       // fwrite(STDERR, print_r($data, TRUE));

        $this->json('POST', route('api_register'),$data)
        ->assertStatus(201)
        ->assertJsonStructure([
            'token',
            "role_name",
            "UserTypeId",
        ]);
        
        $this->role2 = Role::create([
            'name' => 'customer'
        ]);

        $data = [
            'umbrella_id' => 1
        ];

        $this->json('POST', route('api_register'),$data)
        ->assertStatus(201)
        ->assertJsonStructure([
            'token',
            'orderId',
            "role_name",
            "UserTypeId",
        ]);;

        $data = [
            'role_name'=> $role->role_name,
        ];

        $this->json('POST', route('api_register'),$data)
        ->assertStatus(401)
        ->assertJsonStructure([
            'error'
        ]);

        $this->role2 = Role::create([
            'name' => 'kitchen'
        ]);

        $data = [
            'umbrella_id' => -1
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
        ->assertStatus(200)
        ->assertJsonStructure([
            'token'
        ]);

        $id = $userType->id + 1;

        $data = [
            'id'=> $id
        ];

        $this->json('POST', route('api_login'),$data)
        ->assertStatus(500)
        ->assertJsonStructure([
            'error'
        ]);  
        
        $data = [];

        $this->json('POST', route('api_login'),$data)
        ->assertStatus(401)
        ->assertJsonStructure([
            'error'
        ]);  
    }

    public function testGetToken()
    {

        $role =  Role::factory()->create();
        $userType = new UserType;
        $userType->role()->associate($role)->save();
        $token = auth()->login($userType);

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])->json('POST', route('api_refresh'))
        ->assertStatus(201)
        ->assertJsonStructure([
            'refreshedToken'
        ]);
    }

    public function testLogout()
    {
        $role =  Role::factory()->create();
        $userType = new UserType;
        $userType->role()->associate($role)->save();
        $token = auth()->login($userType);

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])->json('POST', route('api_logout'))
        ->assertStatus(200)
        ->assertJsonStructure([
            'message'
        ]);
    }
}
