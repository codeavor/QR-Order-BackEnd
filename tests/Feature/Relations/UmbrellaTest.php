<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Umbrella;
use App\Models\Role;
use App\Models\UserType;

class UmbrellaTest extends TestCase
{

    use RefreshDatabase;

    public function testUmbrellaRelations()
    {
        $role = Role::factory()->create();
        $umbrella = Umbrella::factory()->create();
        $userType = new UserType;

        $userType->role()->associate($role)->save();
        $umbrella->userType()->save($userType);

        $this->assertInstanceOf(UserType::class,$umbrella->userType);
        $this->assertEquals(1,$umbrella->userType->count());
    }
}
