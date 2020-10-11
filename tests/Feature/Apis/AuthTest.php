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
            'role_id' => $role->id
        ];

        fwrite(STDERR, print_r($data, TRUE));

        $this->json('POST', route('register'),$data)
        ->assertStatus(201);

        $data = [
            'role_id'=> 100
        ];

        $this->json('POST', route('register'),$data)
        ->assertStatus(400);

    }

    public function testLogin()
    {
        $role =  Role::factory()->create();
        $userType = new UserType;

        $userType->role()->associate($role)->save();

        $data = [
            'id'=> $userType->id
        ];

        $this->json('POST', route('login'),$data)
        ->assertStatus(200);

        $data = [
            'id'=> $userType->id
        ];

        $this->json('POST', route('login'),$data)
        ->assertStatus(400);

        
    }
}
