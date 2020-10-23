<?php

namespace Tests\Feature\Apis;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Item;
use App\Models\Extra;
use App\Models\UserType;
use App\Models\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuApiTest extends TestCase
{

    use RefreshDatabase;

    protected $role, $userType, $token, $category;

    public function setUp():void
    {
        parent::setUp();
        $this->role =  Role::factory()->create();
        $this->userType = new UserType;
        $this->userType->role()->associate($this->role)->save();
        $this->token = auth()->login($this->userType);
        $this->category = Category::factory()->create();
        $this->role2 = Role::create([
            'name' => 'random'
        ]);
        $this->userType2 = new UserType;
        $this->role2->userTypes()->save($this->userType2);
        $this->token2 = auth()->login($this->userType2);
    }

    public function testShowItem()
    {
       
        $item = Item::factory()->create();
        $extra = Extra::factory()->create();
        $this->category->items()->save($item);
        $item->extras()->attach($extra);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('GET', route('menu.show', $item->id))
        ->assertStatus(200)
        ->assertJson($item->toArray())
        ->assertJsonStructure([
            'id',
            'name',
            'price',
            'category_id',
            'extras' => ['*' => ['id', 'name', 'price', 'pivot' => ['item_id', 'extra_id']]]
        ]);
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('GET', route('menu.show', 100))->assertStatus(404);

        $this->withHeaders(['Authorization' => 'Bearer ' ])->json('GET', route('menu.show', $item->id))
        ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer aklsdjflaksjdf;laksdfnigga' ])->json('GET', route('menu.show', $item->id))
        ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token2])->json('GET', route('menu.show', $item->id))
        ->assertStatus(401);
    }

    public function testShowMenu()
    {
        $items = Item::factory()->count(3)->create();
        $this->category->items()->saveMany($items);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('GET', route('menu.index'))
        ->assertJson($this->category->with('Items')->get()->toArray())
        ->assertJsonStructure([[
            'id',
            'name',
            'description',
            'items' => ['*' => ['id', 'name', 'price', 'category_id']]
        ]])
        ->assertStatus(200);


        $this->withHeaders(['Authorization' => 'Bearer ' ])->json('GET', route('menu.index'))
        ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer aklsdjflaksjdf;laksdfnigga' ])->json('GET', route('menu.index'))
        ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token2])->json('GET', route('menu.index'))
        ->assertStatus(401);
    }
}
