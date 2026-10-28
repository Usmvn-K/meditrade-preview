<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'pos_price' => 'nullable|numeric|min:0',
            'website_price' => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'promotional_discount' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new_arrival' => 'boolean',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'related_products' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_prod_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/services'), $filename);
            $validated['image'] = '/uploads/services/' . $filename;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $fname = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/services'), $fname);
                $galleryPaths[] = '/uploads/services/' . $fname;
            }
            $validated['images'] = $galleryPaths;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_best_seller'] = $request->has('is_best_seller');
        $validated['is_new_arrival'] = $request->has('is_new_arrival');

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'pos_price' => 'nullable|numeric|min:0',
            'website_price' => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'promotional_discount' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new_arrival' => 'boolean',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'related_products' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_prod_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/services'), $filename);
            $validated['image'] = '/uploads/services/' . $filename;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = $product->images ?? [];
            foreach ($request->file('gallery') as $image) {
                $fname = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/services'), $fname);
                $galleryPaths[] = '/uploads/services/' . $fname;
            }
            $validated['images'] = $galleryPaths;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_best_seller'] = $request->has('is_best_seller');
        $validated['is_new_arrival'] = $request->has('is_new_arrival');

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && str_starts_with($product->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
