<?php

namespace Database\Seeders;

use App\Models\Foods;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $foods = [
      // Makanan Berat (categories_id: 1)
      [
        'name' => 'Nasi Goreng Spesial',
        'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar. Disajikan dengan kerupuk dan acar.',
        'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400',
        'price' => 25000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 1,
      ],
      [
        'name' => 'Mie Ayam Bakso',
        'description' => 'Mie ayam dengan topping bakso sapi, pangsit, dan sayuran hijau.',
        'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400',
        'price' => 20000,
        'price_afterdiscount' => '15000',
        'percent' => '25',
        'is_promo' => true,
        'categories_id' => 1,
      ],
      [
        'name' => 'Ayam Geprek',
        'description' => 'Ayam goreng crispy dengan sambal geprek pedas level 1-5. Disajikan dengan nasi putih.',
        'image' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=400',
        'price' => 22000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 1,
      ],
      [
        'name' => 'Soto Ayam',
        'description' => 'Soto ayam kuning dengan suwiran ayam, telur, dan kentang. Disajikan dengan nasi dan emping.',
        'image' => 'https://images.unsplash.com/photo-1604908815574-c433e10b661c?w=400',
        'price' => 18000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 1,
      ],

      // Makanan Ringan (categories_id: 2)
      [
        'name' => 'Kentang Goreng',
        'description' => 'Kentang goreng crispy dengan saus sambal dan mayones.',
        'image' => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=400',
        'price' => 15000,
        'price_afterdiscount' => '12000',
        'percent' => '20',
        'is_promo' => true,
        'categories_id' => 2,
      ],
      [
        'name' => 'Pisang Goreng Keju',
        'description' => 'Pisang goreng crispy dengan topping keju leleh dan meses coklat.',
        'image' => 'https://images.unsplash.com/photo-1528751014936-863e6e7a319c?w=400',
        'price' => 12000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 2,
      ],
      [
        'name' => 'Cireng Isi',
        'description' => 'Cireng dengan isian daging ayam dan bumbu rujak pedas manis.',
        'image' => 'https://images.unsplash.com/photo-1606755962773-d324e0a13086?w=400',
        'price' => 10000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 2,
      ],

      // Minuman (categories_id: 3)
      [
        'name' => 'Es Teh Manis',
        'description' => 'Teh manis segar dengan es batu, minuman klasik Indonesia.',
        'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400',
        'price' => 5000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 3,
      ],
      [
        'name' => 'Es Jeruk Peras',
        'description' => 'Jeruk peras segar dengan es batu, kaya vitamin C.',
        'image' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=400',
        'price' => 8000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 3,
      ],
      [
        'name' => 'Kopi Susu Gula Aren',
        'description' => 'Kopi robusta dengan susu dan gula aren asli, creamy dan manis.',
        'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400',
        'price' => 15000,
        'price_afterdiscount' => '12000',
        'percent' => '20',
        'is_promo' => true,
        'categories_id' => 3,
      ],
      [
        'name' => 'Milkshake Coklat',
        'description' => 'Milkshake coklat premium dengan whipped cream dan taburan coklat.',
        'image' => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?w=400',
        'price' => 18000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 3,
      ],

      // Dessert (categories_id: 4)
      [
        'name' => 'Es Krim Sundae',
        'description' => 'Es krim vanilla dengan saus coklat, kacang, dan cherry di atasnya.',
        'image' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400',
        'price' => 20000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 4,
      ],
      [
        'name' => 'Brownies Lumer',
        'description' => 'Brownies coklat dengan lelehan coklat di dalamnya, disajikan hangat.',
        'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=400',
        'price' => 16000,
        'price_afterdiscount' => null,
        'percent' => null,
        'is_promo' => false,
        'categories_id' => 4,
      ],

      // Paket Hemat (categories_id: 5)
      [
        'name' => 'Paket Nasi Ayam + Es Teh',
        'description' => 'Paket hemat nasi ayam goreng lengkap dengan es teh manis.',
        'image' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=400',
        'price' => 30000,
        'price_afterdiscount' => '25000',
        'percent' => '17',
        'is_promo' => true,
        'categories_id' => 5,
      ],
      [
        'name' => 'Paket Mie Komplit',
        'description' => 'Mie ayam bakso + es jeruk + kerupuk. Hemat dan kenyang!',
        'image' => 'https://images.unsplash.com/photo-1552611052-33e04de081de?w=400',
        'price' => 28000,
        'price_afterdiscount' => '23000',
        'percent' => '18',
        'is_promo' => true,
        'categories_id' => 5,
      ],
    ];

    foreach ($foods as $food) {
      Foods::create($food);
    }
  }
}
