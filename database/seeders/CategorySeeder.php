<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      ['name' => 'Makanan Berat'],
      ['name' => 'Makanan Ringan'],
      ['name' => 'Minuman'],
      ['name' => 'Dessert'],
      ['name' => 'Paket Hemat'],
    ];

    foreach ($categories as $category) {
      Category::create($category);
    }
  }
}
