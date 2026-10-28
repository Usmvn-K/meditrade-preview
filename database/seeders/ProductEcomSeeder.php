<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\User;
use App\Models\City;
use App\Models\Feature;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductEcomSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear existing services and categories
        // Disable foreign key checks for truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Service::truncate();
        ServiceCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Get Admin User (as single vendor)
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Store Admin',
                'email' => 'admin@store.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // 3. Define Product Categories
        $categories = [
            [
                'name' => 'Electronics',
                'icon' => 'fa-laptop',
                'color' => '#3B82F6',
                'description' => 'Latest gadgets and tech equipment.',
                'sub' => ['Smartphones', 'Laptops', 'Accessories']
            ],
            [
                'name' => 'Fashion',
                'icon' => 'fa-shirt',
                'color' => '#EF4444',
                'description' => 'Premium apparel and accessories.',
                'sub' => ['Men', 'Women', 'Footwear']
            ],
            [
                'name' => 'Home & Living',
                'icon' => 'fa-house-chimney',
                'color' => '#10B981',
                'description' => 'Everything for your home.',
                'sub' => ['Furniture', 'Decor', 'Kitchenware']
            ],
            [
                'name' => 'Luxury Watches',
                'icon' => 'fa-clock',
                'color' => '#F59E0B',
                'description' => 'High-end timepieces.',
                'sub' => ['Automatic', 'Chronograph', 'Classic']
            ]
        ];

        foreach ($categories as $index => $catData) {
            $parent = ServiceCategory::create([
                'name' => $catData['name'],
                'slug' => Str::slug($catData['name']),
                'icon' => $catData['icon'],
                'color' => $catData['color'],
                'description' => $catData['description'],
                'is_active' => true,
                'sort_order' => $index
            ]);

            foreach ($catData['sub'] as $subIndex => $subName) {
                $child = ServiceCategory::create([
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'parent_id' => $parent->id,
                    'is_active' => true,
                    'sort_order' => $subIndex
                ]);

                // Create Products for this subcategory
                for ($i = 1; $i <= 3; $i++) {
                    $price = rand(50, 5000);
                    Service::create([
                        'category_id' => $child->id,
                        'user_id' => $admin->id,
                        'name' => "Premium " . $subName . " Item " . $i,
                        'description' => "This is a premium " . strtolower($subName) . " product designed for elite quality and performance.",
                        'price' => $price,
                        'price_type' => 'fixed',
                        'location' => 'Store Warehouse',
                        'status' => 'active',
                        'is_featured' => rand(0, 1),
                        'images' => [
                            'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=2099&auto=format&fit=crop',
                            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=2070&auto=format&fit=crop'
                        ],
                        'featured_image_index' => 0
                    ]);
                }
            }
        }

        // 4. Seed Cities
        City::query()->forceDelete();
        $cities = ['Karachi', 'Lahore', 'Islamabad', 'Faisalabad', 'Multan', 'Dubai', 'London', 'New York'];
        foreach ($cities as $cityName) {
            City::create([
                'name' => $cityName,
                'slug' => Str::slug($cityName)
            ]);
        }

        // 5. Seed Features
        Feature::truncate();
        $features = [
            ['title' => 'Browse Collections', 'description' => 'Explore premium products with transparent pricing.', 'icon' => 'fa-magnifying-glass'],
            ['title' => 'Secure Checkout', 'description' => 'Global payment options with escrow-secured protection.', 'icon' => 'fa-shield-check'],
            ['title' => 'Global Delivery', 'description' => 'Door-to-door shipping across 150+ countries.', 'icon' => 'fa-truck-fast']
        ];
        foreach ($features as $index => $f) {
            Feature::create(['title' => $f['title'], 'description' => $f['description'], 'icon' => $f['icon'], 'order' => $index]);
        }

        // 6. Seed Testimonials
        Testimonial::truncate();
        $testimonials = [
            ['name' => 'Sarah Ahmed', 'role' => 'Premium Customer', 'quote' => 'Exceptional quality and authentic luxury. The delivery was remarkably fast.', 'stars' => 5],
            ['name' => 'Ali Khan', 'role' => 'Corporate Partner', 'quote' => 'The wholesale experience is unparalleled. Perfect for corporate gifting.', 'stars' => 5],
            ['name' => 'Fatima Hassan', 'role' => 'Loyal Customer', 'quote' => 'Verified products and excellent support. Best shopping experience in Pakistan.', 'stars' => 5]
        ];
        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }
    }
}
