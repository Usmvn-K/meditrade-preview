<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-plus text-orange-600 mr-2"></i>{{ __('Add New Sub Category') }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">Create a sub category under an existing parent category</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('admin.sub-categories.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div>
                        <label for="parent_id" class="block text-sm font-bold text-gray-700 uppercase mb-2">Parent Category <span class="text-red-500">*</span></label>
                        <select name="parent_id" id="parent_id" required
                            class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 transition px-4 py-3 text-sm">
                            <option value="">Select Parent Category...</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 uppercase mb-2">Sub Category Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required
                            class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 transition px-4 py-3 text-sm"
                            placeholder="e.g. Mobiles, T-Shirts, Laptops" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="icon" class="block text-sm font-bold text-gray-700 uppercase mb-2">Icon (FontAwesome)</label>
                            <input type="text" name="icon" id="icon"
                                class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 transition px-4 py-3 text-sm"
                                placeholder="e.g. fa-mobile-screen" value="{{ old('icon') }}">
                            @error('icon')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-bold text-gray-700 uppercase mb-2">Color</label>
                            <input type="color" name="color" id="color"
                                class="w-full rounded-xl border-gray-200 h-12 cursor-pointer"
                                value="{{ old('color', '#6366f1') }}">
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 uppercase mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 transition px-4 py-3 text-sm"
                            placeholder="Brief description (optional)">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-bold text-gray-700 uppercase mb-2">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order"
                            class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 transition px-4 py-3 text-sm"
                            placeholder="0" value="{{ old('sort_order', 0) }}">
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.sub-categories.index') }}"
                            class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition-all">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-5 py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-orange-500/20 transition-all">
                            Save Sub Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
