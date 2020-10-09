<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Umbrella;
use App\Models\Role;
use App\Models\UserType;

class RoleTest extends TestCase
{

    use RefreshDatabase;

    public function testRoleRelations()
    {
        $role = Role::factory()->create();
        $umbrella = Umbrella::factory()->create();
        $userType = new UserType;

        $role->userTypes()->save($userType);
        $userType->umbrella()->associate($umbrella)->save();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $role->userTypes);
        $this->assertEquals(1,$role->userTypes->count());
        $this->assertTrue($role->userTypes->contains($userType));
    }
}
