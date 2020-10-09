<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Umbrella;
use App\Models\Role;
use App\Models\UserType;

class UserTypeTest extends TestCase
{
    use RefreshDatabase;

    public function testUserTypeRelations()
    {
        $role = Role::factory()->create();
        $umbrella = Umbrella::factory()->create();
        $userType = new UserType;

        $userType->role()->associate($role)->save();
        $userType->umbrella()->associate($umbrella)->save();

        $this->assertInstanceOf(Umbrella::class,$userType->umbrella);
        $this->assertEquals(1,$userType->umbrella->count());

        $this->assertInstanceOf(Role::class,$userType->role);
        $this->assertEquals(1,$userType->role->count());

    }
}
