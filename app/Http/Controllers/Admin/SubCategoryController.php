<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = ServiceCategory::whereNotNull('parent_id')
            ->with('parent')
            ->orderBy('sort_order')
            ->paginate(10);

        return view('admin.sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        $parentCategories = ServiceCategory::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.sub-categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'required|exists:service_categories,id',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
        ]);

        ServiceCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
            'description' => $request->description,
            'color' => $request->color ?? '#6366f1',
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub Category created successfully.');
    }

    public function edit(ServiceCategory $sub_category)
    {
        $parentCategories = ServiceCategory::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.sub-categories.edit', compact('sub_category', 'parentCategories'));
    }

    public function update(Request $request, ServiceCategory $sub_category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'required|exists:service_categories,id',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
        ]);

        $sub_category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
            'description' => $request->description,
            'color' => $request->color,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub Category updated successfully.');
    }

    public function destroy(ServiceCategory $sub_category)
    {
        $sub_category->delete();
        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub Category deleted successfully.');
    }
}
