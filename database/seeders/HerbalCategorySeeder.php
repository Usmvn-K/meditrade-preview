<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use Illuminate\Support\Str;

class HerbalCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Organic Herbal Teas',
                'slug' => 'organic-herbal-teas',
                'icon' => 'fa-mug-hot',
                'image' => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?q=80&w=1200&auto=format&fit=crop',
                'description' => '100% pure loose leaf green teas, chamomile, peppermint, and detox herbal infusions.',
                'color' => '#15803d',
                'sort_order' => 1,
            ],
            [
                'name' => 'Essential Oils & Aroma',
                'slug' => 'essential-oils-aroma',
                'icon' => 'fa-vial',
                'image' => 'https://images.unsplash.com/photo-1608248597260-6521e8e1218a?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Cold-pressed lavender, eucalyptus, tea tree, and therapeutic essential oil drops.',
                'color' => '#d97706',
                'sort_order' => 2,
            ],
            [
                'name' => 'Botanical Skincare',
                'slug' => 'botanical-skincare',
                'icon' => 'fa-spa',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Chemical-free facial serums, organic aloe gels, rose water, and herbal clay masks.',
                'color' => '#16a34a',
                'sort_order' => 3,
            ],
            [
                'name' => 'Herbal Health Remedies',
                'slug' => 'herbal-health-remedies',
                'icon' => 'fa-mortar-pestle',
                'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Traditional ayurvedic formulations, unrefined honey remedies, and herbal elixirs.',
                'color' => '#b45309',
                'sort_order' => 4,
            ],
            [
                'name' => 'Raw Herbs & Spices',
                'slug' => 'raw-herbs-spices',
                'icon' => 'fa-seedling',
                'image' => 'https://images.unsplash.com/photo-1509358271058-acd05cc93898?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Direct farm-sourced organic turmeric, cinnamon sticks, saffron, and dried roots.',
                'color' => '#15803d',
                'sort_order' => 5,
            ],
            [
                'name' => 'Natural Hair Care Oils',
                'slug' => 'natural-hair-care-oils',
                'icon' => 'fa-droplet',
                'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Pure onion oil, black seed oil, coconut oil, and 21-herb anti-hairfall blends.',
                'color' => '#052e16',
                'sort_order' => 6,
            ],
            [
                'name' => 'Immunity & Detox',
                'slug' => 'immunity-detox',
                'icon' => 'fa-shield-heart',
                'image' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Natural wellness supplements, moringa powder, and organic immunity boosters.',
                'color' => '#d97706',
                'sort_order' => 7,
            ],
            [
                'name' => 'Aromatic Incense & Resins',
                'slug' => 'aromatic-incense-resins',
                'icon' => 'fa-fire-flame-curved',
                'image' => 'https://images.unsplash.com/photo-1602928321679-560bb453f190?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Natural bakhoor, organic frankincense resins, and herbal aroma diffuser sticks.',
                'color' => '#14532d',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $catData) {
            ServiceCategory::updateOrCreate(
                ['slug' => $catData['slug']],
                [
                    'name' => $catData['name'],
                    'icon' => $catData['icon'],
                    'image' => $catData['image'],
                    'description' => $catData['description'],
                    'color' => $catData['color'],
                    'sort_order' => $catData['sort_order'],
                    'is_active' => true,
                    'parent_id' => null,
                ]
            );
        }
    }
}
