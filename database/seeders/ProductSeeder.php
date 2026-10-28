<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'           => 'Wireless Bluetooth Earbuds',
                'description'    => 'Premium wireless earbuds with noise cancellation, 30-hour battery life, and crystal clear sound quality. IPX5 water resistant.',
                'price'          => 4999.00,
                'sale_price'     => 3499.00,
                'stock_quantity' => 50,
                'category'       => 'Electronics',
                'image'          => 'https://picsum.photos/seed/earbuds/400/400',
                'status'         => 'active',
                'is_featured'    => true,
            ],
            [
                'name'           => 'Smart Watch Pro',
                'description'    => 'Advanced smartwatch with heart rate monitor, GPS tracking, sleep analysis, and 7-day battery life. Compatible with Android and iOS.',
                'price'          => 12999.00,
                'sale_price'     => null,
                'stock_quantity' => 30,
                'category'       => 'Electronics',
                'image'          => 'https://picsum.photos/seed/smartwatch/400/400',
                'status'         => 'active',
                'is_featured'    => true,
            ],
            [
                'name'           => 'Premium Leather Wallet',
                'description'    => 'Handcrafted genuine leather wallet with RFID blocking technology. Multiple card slots and bill compartments.',
                'price'          => 2499.00,
                'sale_price'     => 1999.00,
                'stock_quantity' => 100,
                'category'       => 'Accessories',
                'image'          => 'https://picsum.photos/seed/wallet/400/400',
                'status'         => 'active',
                'is_featured'    => false,
            ],
            [
                'name'           => 'Running Shoes Ultra',
                'description'    => 'Lightweight running shoes with responsive cushioning, breathable mesh upper, and durable rubber outsole.',
                'price'          => 8999.00,
                'sale_price'     => 6999.00,
                'stock_quantity' => 25,
                'category'       => 'Footwear',
                'image'          => 'https://picsum.photos/seed/shoes/400/400',
                'status'         => 'active',
                'is_featured'    => true,
            ],
            [
                'name'           => 'Cotton T-Shirt Pack (3)',
                'description'    => 'Premium 100% cotton t-shirts. Pack of 3 in black, white, and grey. Comfortable fit for everyday wear.',
                'price'          => 1999.00,
                'sale_price'     => null,
                'stock_quantity' => 200,
                'category'       => 'Clothing',
                'image'          => 'https://picsum.photos/seed/tshirt/400/400',
                'status'         => 'active',
                'is_featured'    => false,
            ],
            [
                'name'           => 'Portable Power Bank 20000mAh',
                'description'    => 'High capacity power bank with dual USB ports, fast charging support, and LED battery indicator.',
                'price'          => 3499.00,
                'sale_price'     => 2999.00,
                'stock_quantity' => 75,
                'category'       => 'Electronics',
                'image'          => 'https://picsum.photos/seed/powerbank/400/400',
                'status'         => 'active',
                'is_featured'    => false,
            ],
            [
                'name'           => 'Sunglasses Classic Aviator',
                'description'    => 'Classic aviator style sunglasses with UV400 protection and polarized lenses. Lightweight metal frame.',
                'price'          => 1499.00,
                'sale_price'     => null,
                'stock_quantity' => 60,
                'category'       => 'Accessories',
                'image'          => 'https://picsum.photos/seed/sunglasses/400/400',
                'status'         => 'active',
                'is_featured'    => false,
            ],
            [
                'name'           => 'Backpack Travel Pro',
                'description'    => 'Spacious 40L travel backpack with laptop compartment, anti-theft pocket, and USB charging port.',
                'price'          => 5999.00,
                'sale_price'     => 4499.00,
                'stock_quantity' => 40,
                'category'       => 'Bags',
                'image'          => 'https://picsum.photos/seed/backpack/400/400',
                'status'         => 'active',
                'is_featured'    => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
