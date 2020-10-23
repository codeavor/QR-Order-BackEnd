<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Category;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    public function testCategoryRelations()
    {
        $category = Category::factory()->create();
        $item = Item::factory()->create();
        $category->items()->save($item);
        
        // Tests for user type relation one to many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->items);
        $this->assertEquals(1,$category->items->count());
        $this->assertTrue($category->items->contains($item));
    }
}
