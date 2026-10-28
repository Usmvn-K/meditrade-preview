<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-pen text-green-600 mr-2"></i>{{ __('Edit Service Category') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Updating: {{ $serviceCategory->name }}</p>
            </div>
            <a href="{{ route('admin.service-categories.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <form method="POST" action="{{ route('admin.service-categories.update', $serviceCategory->id) }}" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $serviceCategory->name) }}" required
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Category Banner / Card Image Upload -->
                        <div class="col-span-2 p-5 bg-gradient-to-r from-emerald-50/60 to-teal-50/40 border border-emerald-100 rounded-2xl">
                            <label for="image" class="block text-sm font-bold text-emerald-900 mb-1 flex items-center gap-2">
                                <i class="fa-solid fa-image text-emerald-600"></i> Category Cover / Card Image
                            </label>
                            <p class="text-xs text-emerald-700 mb-3">Upload high quality image for homepage category carousel & catalog cards</p>
                            
                            @if($serviceCategory->image)
                                <div class="mb-3 p-3 bg-white border border-emerald-200 rounded-xl inline-flex items-center gap-3">
                                    <img src="{{ mediaUrl($serviceCategory->image) }}"
                                         alt="{{ $serviceCategory->name }}" class="h-16 w-24 object-cover rounded-lg shadow-sm">
                                    <div>
                                        <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md">Current Image</span>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Upload new image below to replace</p>
                                    </div>
                                </div>
                            @endif

                            <input type="file" name="image" id="image" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Parent Category -->
                        <div class="col-span-2">
                            <label for="parent_id" class="block text-sm font-bold text-gray-700 mb-2">Parent Category (Optional)</label>
                            <select name="parent_id" id="parent_id"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                                <option value="">None (Make this a Parent)</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $serviceCategory->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-gray-400 text-xs mt-1">Changing parent will move this category in the hierarchy.</p>
                            @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Icon -->
                        <div>
                            <label for="icon" class="block text-sm font-bold text-gray-700 mb-2">Icon (FontAwesome Class)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <i class="fa-solid {{ $serviceCategory->icon ?: 'fa-icons' }}"></i>
                                </span>
                                <input type="text" name="icon" id="icon" value="{{ old('icon', $serviceCategory->icon) }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                            </div>
                            @error('icon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="color" class="block text-sm font-bold text-gray-700 mb-2">Theme Color</label>
                            <div class="flex gap-2">
                                <input type="color" name="color" id="color" value="{{ old('color', $serviceCategory->color) }}"
                                    class="h-12 w-20 p-1 rounded-xl border border-gray-200 cursor-pointer">
                                <input type="text" id="color_text" value="{{ old('color', $serviceCategory->color) }}"
                                    class="flex-1 px-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all uppercase"
                                    oninput="document.getElementById('color').value = this.value">
                            </div>
                            @error('color') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-bold text-gray-700 mb-2">Display Order</label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $serviceCategory->sort_order) }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                            @error('sort_order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Short Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">{{ old('description', $serviceCategory->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold shadow-lg shadow-green-500/30 transition-all">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('color').addEventListener('input', function() {
            document.getElementById('color_text').value = this.value.toUpperCase();
        });
    </script>
</x-app-layout>

