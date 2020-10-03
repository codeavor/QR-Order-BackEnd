<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Item;
use App\Models\Extra;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuApiTest extends TestCase
{

    use RefreshDatabase;

    public function testShowItem()
    {
        $category = Category::factory()->create();
        $item = Item::factory()->create();
        $extra = Extra::factory()->create();
        $category->items()->save($item);
        $item->extras()->attach($extra);
        $this->get(route('menu.show', $item->id))->assertStatus(200)
        ->assertJson($item->toArray())
        ->assertJsonStructure([
            'id',
            'name',
            'price',
            'category_id',
            'extras' => ['*' => ['id', 'name', 'price', 'pivot' => ['item_id', 'extra_id']]]
        ]);
        $this->get(route('menu.show', 100))->assertStatus(404);
    }

    public function testShowMenu()
    {
        $category = Category::factory()->create();
        $items = Item::factory()->count(3)->create();
        $category->items()->saveMany($items);

        $this->get(route('menu.index'))
        ->assertJson($category->with('Items')->get()->toArray())
        ->assertJsonStructure([[
            'id',
            'name',
            'description',
            'items' => ['*' => ['id', 'name', 'price', 'category_id']]
        ]])
        ->assertStatus(200);

    }
}
