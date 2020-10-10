<?php

namespace Tests\Feature\Apis;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\UserType;
use App\Models\Role;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $role =  Role::factory()->create();
        $data = [
            'role_id'=> $role->id,
        ];

        $response = $this->post(route('register'),$data, ['Accept' => 'text/plain'])
        ->assertStatus(201);
        $data = [
            'role_id'=> 100,
        ];

        $response = $this->post(route('register'),$data, ['Accept' => 'text/plain'])
        ->assertStatus(400);
    }

    public function testLogin()
    {
        $role =  Role::factory()->create();
        $userType = new UserType;

        $userType->role()->associate($role)->save();

        $data = [
            'id'=> $userType->id,
        ];

        $response = $this->post(route('login'),$data, ['Accept' => 'text/plain'])
        ->assertStatus(200);

        $data = [
            'id'=> $userType->id,
        ];

        $response = $this->post(route('login'),$data, ['Accept' => 'text/plain'])
        ->assertStatus(400);

        
    }
}
