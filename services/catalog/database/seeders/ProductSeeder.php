<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Classic Cheeseburger',
                'description' => 'A juicy grilled beef patty with melted cheese, lettuce, and tomato.',
                'price' => 149.99,
                'stock' => 50,
                'image_url' => 'https://via.placeholder.com/300x200?text=Cheeseburger',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Chicken Sandwich',
                'description' => 'Crispy chicken fillet with mayo and lettuce on a soft bun.',
                'price' => 129.99,
                'stock' => 40,
                'image_url' => 'https://via.placeholder.com/300x200?text=Chicken+Sandwich',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Bacon Double Burger',
                'description' => 'Two beef patties, crispy bacon, cheese, and special sauce.',
                'price' => 199.00,
                'stock' => 30,
                'image_url' => 'https://via.placeholder.com/300x200?text=Bacon+Burger',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Veggie Delight',
                'description' => 'A plant-based burger packed with vegetables and flavor.',
                'price' => 119.00,
                'stock' => 25,
                'image_url' => 'https://via.placeholder.com/300x200?text=Veggie+Burger',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'BBQ Burger',
                'description' => 'Smoky barbecue sauce with grilled onions and cheese.',
                'price' => 159.00,
                'stock' => 35,
                'image_url' => 'https://via.placeholder.com/300x200?text=BBQ+Burger',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Spicy Chicken Wrap',
                'description' => 'Grilled chicken, veggies, and spicy sauce in a warm tortilla.',
                'price' => 139.00,
                'stock' => 45,
                'image_url' => 'https://via.placeholder.com/300x200?text=Spicy+Wrap',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Fish Fillet Burger',
                'description' => 'Crispy fish fillet with tartar sauce and lettuce.',
                'price' => 149.00,
                'stock' => 20,
                'image_url' => 'https://via.placeholder.com/300x200?text=Fish+Burger',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Mushroom Melt Burger',
                'description' => 'Grilled beef topped with sautéed mushrooms and melted cheese.',
                'price' => 179.00,
                'stock' => 28,
                'image_url' => 'https://via.placeholder.com/300x200?text=Mushroom+Burger',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Crispy Fries',
                'description' => 'Golden crispy fries, perfect with any meal.',
                'price' => 79.00,
                'stock' => 100,
                'image_url' => 'https://via.placeholder.com/300x200?text=Fries',
            ],
            [
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'name' => 'Iced Coffee',
                'description' => 'Refreshing cold coffee with creamy milk and sugar.',
                'price' => 99.00,
                'stock' => 60,
                'image_url' => 'https://via.placeholder.com/300x200?text=Iced+Coffee',
            ],
        ];

        DB::table('products')->insert($products);
    }
}
