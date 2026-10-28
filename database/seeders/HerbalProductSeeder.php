<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Models\Setting;

class HerbalProductSeeder extends Seeder
{
    public function run(): void
    {
        // Update DB Settings so TECH references are 100% HERBAL
        Setting::updateOrCreate(['key' => 'tech_heading'], ['value' => 'ESSENTIAL OILS & BOTANICAL EXTRACTS']);
        Setting::updateOrCreate(['key' => 'tech_subtitle'], ['value' => '100% pure cold-pressed oils, aroma extracts, and therapeutic organic remedies.']);
        Setting::updateOrCreate(['key' => 'tech_btn_text'], ['value' => 'EXPLORE ESSENTIAL OILS 🌿']);
        Setting::updateOrCreate(['key' => 'tech_btn_bg'], ['value' => '#15803d']);
        
        Setting::updateOrCreate(['key' => 'enterprise_heading'], ['value' => 'RAW HERBS & WHOLESALE SUPPLIES']);
        Setting::updateOrCreate(['key' => 'enterprise_subtitle'], ['value' => 'Direct farm-sourced organic herbs, bulk essential oils, and botanical formulations.']);
        Setting::updateOrCreate(['key' => 'enterprise_tag'], ['value' => 'BULK & WHOLESALE HERBAL CARE']);

        // Find or create admin/vendor user
        $user = User::where('role', 'vendor')->first() ?? User::where('role', 'admin')->first() ?? User::first();

        // Get categories
        $oilsCat = ServiceCategory::where('slug', 'essential-oils-aroma')->first();
        $teaCat = ServiceCategory::where('slug', 'organic-herbal-teas')->first();
        $hairCat = ServiceCategory::where('slug', 'natural-hair-care-oils')->first();
        $skinCat = ServiceCategory::where('slug', 'botanical-skincare')->first();
        $spicesCat = ServiceCategory::where('slug', 'raw-herbs-spices')->first();
        $immunityCat = ServiceCategory::where('slug', 'immunity-detox')->first();

        $defaultCat = ServiceCategory::first();

        // Delete test products like ASDASD, MacBook, Electronics
        Service::where('name', 'like', '%ASDASD%')
            ->orWhere('name', 'like', '%MACBOOK%')
            ->orWhere('name', 'like', '%SONY%')
            ->orWhere('name', 'like', '%ELECTRONICS%')
            ->delete();

        $herbalProducts = [
            [
                'name' => 'Pure Organic Lavender Essential Oil',
                'description' => '100% Pure therapeutic grade lavender essential oil cold-pressed for stress relief, calm sleep, and aromatherapy.',
                'price' => 1850,
                'sale_price' => 1450,
                'is_on_sale' => true,
                'category_id' => $oilsCat ? $oilsCat->id : $defaultCat->id,
                'brand' => 'Gohar Botanical',
                'image' => 'https://images.unsplash.com/photo-1608248597260-6521e8e1218a?q=80&w=1200&auto=format&fit=crop',
                'images' => ['https://images.unsplash.com/photo-1608248597260-6521e8e1218a?q=80&w=1200&auto=format&fit=crop'],
                'location' => 'Lahore, Pakistan',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Himalayan Chamomile & Peppermint Tea',
                'description' => 'Organic loose leaf chamomile flowers blended with fresh mountain mint for digestive wellness and relaxation.',
                'price' => 1200,
                'sale_price' => 950,
                'is_on_sale' => true,
                'category_id' => $teaCat ? $teaCat->id : $defaultCat->id,
                'brand' => 'Gohar Teas',
                'image' => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?q=80&w=1200&auto=format&fit=crop',
                'images' => ['https://images.unsplash.com/photo-1576092768241-dec231879fc3?q=80&w=1200&auto=format&fit=crop'],
                'location' => 'Islamabad, Pakistan',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => '21-Herb Botanical Hair Growth Oil',
                'description' => 'Hand-infused blend of Amla, Reetha, Shikakai, and 21 rare botanical herbs for hair strength, volume, and scalp health.',
                'price' => 2400,
                'sale_price' => 1950,
                'is_on_sale' => true,
                'category_id' => $hairCat ? $hairCat->id : $defaultCat->id,
                'brand' => 'Gohar Herbal',
                'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?q=80&w=1200&auto=format&fit=crop',
                'images' => ['https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?q=80&w=1200&auto=format&fit=crop'],
                'location' => 'Karachi, Pakistan',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Organic Saffron & Rose Glow Serum',
                'description' => 'Chemical-free facial glow serum enriched with pure Kashmiri saffron, rosehip oil, and vitamin C botanicals.',
                'price' => 3200,
                'sale_price' => 2750,
                'is_on_sale' => true,
                'category_id' => $skinCat ? $skinCat->id : $defaultCat->id,
                'brand' => 'Gohar Skin',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?q=80&w=1200&auto=format&fit=crop',
                'images' => ['https://images.unsplash.com/photo-1556228720-195a672e8a03?q=80&w=1200&auto=format&fit=crop'],
                'location' => 'Lahore, Pakistan',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Cold-Pressed Raw Moroccan Argan Oil',
                'description' => '100% Pure unrefined Argan oil for intensive hair hydration, skin elasticity, and beard care.',
                'price' => 2900,
                'sale_price' => 2400,
                'is_on_sale' => true,
                'category_id' => $oilsCat ? $oilsCat->id : $defaultCat->id,
                'brand' => 'Gohar Oils',
                'image' => 'https://images.unsplash.com/photo-1608248548823-8a76be558ddc?q=80&w=1200&auto=format&fit=crop',
                'images' => ['https://images.unsplash.com/photo-1608248548823-8a76be558ddc?q=80&w=1200&auto=format&fit=crop'],
                'location' => 'Islamabad, Pakistan',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Wildflower Honey & Ginger Immunity Tonic',
                'description' => 'Raw unpasteurized forest honey infused with organic ginger, turmeric, and lemon peel for natural immunity.',
                'price' => 1600,
                'sale_price' => 1300,
                'is_on_sale' => true,
                'category_id' => $immunityCat ? $immunityCat->id : $defaultCat->id,
                'brand' => 'Gohar Remedies',
                'image' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?q=80&w=1200&auto=format&fit=crop',
                'images' => ['https://images.unsplash.com/photo-1615485290382-441e4d049cb5?q=80&w=1200&auto=format&fit=crop'],
                'location' => 'Rawalpindi, Pakistan',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'STAMANAX 1000mg Herbal Vitality Capsules',
                'description' => '100% Organic botanical stamina and energy booster. Formulated with pure Shilajit, Ashwagandha, and rare mountain herbs for male vitality and endurance.',
                'price' => 3500,
                'sale_price' => 2750,
                'is_on_sale' => true,
                'category_id' => $immunityCat ? $immunityCat->id : $defaultCat->id,
                'brand' => 'StamanX Care',
                'image' => '/images/stamanax_product.png',
                'images' => ['/images/stamanax_product.png', '/images/landmarks/stamanax_product_1.png'],
                'location' => 'Lahore, Pakistan',
                'is_featured' => true,
                'status' => 'active',
            ],
        ];

        foreach ($herbalProducts as $pData) {
            Service::updateOrCreate(
                ['name' => $pData['name']],
                array_merge($pData, ['user_id' => $user->id])
            );
        }
    }
}
