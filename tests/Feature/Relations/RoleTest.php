<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Models\UserType;

class RoleTest extends TestCase
{

    use RefreshDatabase;

    public function testRoleRelations()
    {
        $role = Role::factory()->create();
        $userType = new UserType;
        $role->userTypes()->save($userType);
        
        // Tests for user type relation one to many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $role->userTypes);
        $this->assertEquals(1,$role->userTypes->count());
        $this->assertTrue($role->userTypes->contains($userType));
    }
}
