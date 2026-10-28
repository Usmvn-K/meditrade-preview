<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sub_category')->nullable();
            $table->string('brand')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('pos_price', 10, 2)->default(0);
            $table->decimal('website_price', 10, 2)->default(0);
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('promotional_discount', 10, 2)->nullable();
            $table->text('short_description')->nullable();
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->json('related_products')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sub_category',
                'brand',
                'unit',
                'pos_price',
                'website_price',
                'purchase_price',
                'promotional_discount',
                'short_description',
                'is_best_seller',
                'is_new_arrival',
                'related_products'
            ]);
        });
    }
};
