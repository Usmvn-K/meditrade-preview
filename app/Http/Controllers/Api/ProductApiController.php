<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * List all active products (with optional search/category filter)
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 'active');

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Featured only
        if ($request->has('featured') && $request->featured) {
            $query->where('is_featured', true);
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        $formatted = $products->map(function ($product) {
            return [
                'id'             => $product->id,
                'name'           => $product->name,
                'description'    => $product->description,
                'price'          => (float) $product->price,
                'sale_price'     => $product->sale_price ? (float) $product->sale_price : null,
                'current_price'  => (float) $product->getCurrentPrice(),
                'is_on_sale'     => $product->isOnSale(),
                'stock_quantity' => $product->stock_quantity,
                'in_stock'       => $product->inStock(),
                'category'       => $product->category,
                'image'          => $product->getFeaturedImage(),
                'images'         => $product->getAllImages(),
                'is_featured'    => $product->is_featured,
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Show a single product
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product || $product->status !== 'active') {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'id'             => $product->id,
            'name'           => $product->name,
            'description'    => $product->description,
            'price'          => (float) $product->price,
            'sale_price'     => $product->sale_price ? (float) $product->sale_price : null,
            'current_price'  => (float) $product->getCurrentPrice(),
            'is_on_sale'     => $product->isOnSale(),
            'stock_quantity' => $product->stock_quantity,
            'in_stock'       => $product->inStock(),
            'category'       => $product->category,
            'image'          => $product->getFeaturedImage(),
            'images'         => $product->getAllImages(),
            'is_featured'    => $product->is_featured,
        ]);
    }

    /**
     * List all product categories
     */
    public function categories()
    {
        $categories = Product::where('status', 'active')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return response()->json($categories);
    }
}
