<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('sub_category')->nullable()->after('category_id');
            $table->string('brand')->nullable()->after('sub_category');
            $table->string('unit')->nullable()->after('brand');
            $table->text('short_description')->nullable()->after('description');
            $table->decimal('promotional_discount', 10, 2)->nullable()->after('sale_price');
            $table->boolean('is_best_seller')->default(false)->after('is_featured');
            $table->boolean('is_new_arrival')->default(false)->after('is_best_seller');
            $table->json('related_products')->nullable()->after('add_ons');
            $table->string('protocol')->default('simple')->after('price_type');
            $table->decimal('pos_price', 10, 2)->nullable()->after('price');
            $table->decimal('website_price', 10, 2)->nullable()->after('pos_price');
            $table->decimal('purchase_price', 10, 2)->nullable()->after('website_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'sub_category',
                'brand',
                'unit',
                'short_description',
                'promotional_discount',
                'is_best_seller',
                'is_new_arrival',
                'related_products',
                'protocol',
                'pos_price',
                'website_price',
                'purchase_price',
            ]);
        });
    }
};
