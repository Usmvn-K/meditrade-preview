<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'sale_price', 'stock_quantity',
        'category', 'image', 'images', 'sku', 'status', 'is_featured',
        'sub_category', 'brand', 'unit', 'pos_price', 'website_price',
        'purchase_price', 'promotional_discount', 'short_description',
        'is_best_seller', 'is_new_arrival', 'related_products'
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'sale_price' => 'decimal:2',
        'price' => 'decimal:2',
        'pos_price' => 'decimal:2',
        'website_price' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'promotional_discount' => 'decimal:2',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'related_products' => 'array',
    ];

    public function getCurrentPrice()
    {
        return $this->sale_price !== null && $this->sale_price > 0
            ? $this->sale_price
            : $this->price;
    }

    public function isOnSale(): bool
    {
        return $this->sale_price !== null && $this->sale_price > 0 && $this->sale_price < $this->price;
    }

    public function inStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getFeaturedImage()
    {
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        return $this->image;
    }

    public function getAllImages()
    {
        return $this->images ?? ($this->image ? [$this->image] : []);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
