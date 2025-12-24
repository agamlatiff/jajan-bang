<?php

namespace Tests\Feature;

use App\Models\Foods;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoodsTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();

    // Create a test category
    Category::create([
      'name' => 'Test Category',
      'image' => 'test.jpg',
    ]);
  }

  public function test_foods_model_can_be_created(): void
  {
    $food = Foods::create([
      'name' => 'Test Food',
      'description' => 'Test description',
      'price' => 25000,
      'image' => 'test.jpg',
      'categories_id' => 1,
      'is_promo' => false,
    ]);

    $this->assertDatabaseHas('foods', [
      'name' => 'Test Food',
      'price' => 25000,
    ]);
  }

  public function test_foods_can_have_promo(): void
  {
    $food = Foods::create([
      'name' => 'Promo Food',
      'description' => 'Promo item',
      'price' => 50000,
      'image' => 'promo.jpg',
      'categories_id' => 1,
      'is_promo' => true,
      'percent' => 20,
      'price_afterdiscount' => 40000,
    ]);

    $this->assertTrue($food->is_promo);
    $this->assertEquals(40000, $food->price_afterdiscount);
  }

  public function test_foods_belongs_to_category(): void
  {
    $category = Category::first();

    $food = Foods::create([
      'name' => 'Category Food',
      'description' => 'Has category',
      'price' => 30000,
      'image' => 'cat.jpg',
      'categories_id' => $category->id,
    ]);

    $this->assertEquals($category->id, $food->categories_id);
  }

  public function test_get_promo_returns_only_promo_items(): void
  {
    // Create regular food
    Foods::create([
      'name' => 'Regular Food',
      'price' => 20000,
      'image' => 'reg.jpg',
      'categories_id' => 1,
      'is_promo' => false,
    ]);

    // Create promo food
    Foods::create([
      'name' => 'Promo Food',
      'price' => 30000,
      'image' => 'promo.jpg',
      'categories_id' => 1,
      'is_promo' => true,
    ]);

    $foods = new Foods();
    $promos = $foods->getPromo();

    $this->assertCount(1, $promos);
    $this->assertEquals('Promo Food', $promos->first()->name);
  }
}
