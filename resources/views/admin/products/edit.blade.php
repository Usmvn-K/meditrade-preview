<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Product: {{ $product->name }}</h2>
                <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">
                    &larr; Back to Inventory
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Title *</label>
                                <input type="text" name="name" id="name" required class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200" value="{{ old('name', $product->name) }}">
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <input type="text" name="category" id="category" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200" value="{{ old('category', $product->category) }}">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (Rs) *</label>
                                    <input type="number" step="0.01" name="price" id="price" required class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200" value="{{ old('price', $product->price) }}">
                                </div>
                                <div>
                                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">Sale Price (Optional)</label>
                                    <input type="number" step="0.01" name="sale_price" id="sale_price" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200" value="{{ old('sale_price', $product->sale_price) }}">
                                </div>
                            </div>

                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                                <input type="number" name="stock_quantity" id="stock_quantity" required min="0" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200" value="{{ old('stock_quantity', $product->stock_quantity) }}">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Image</label>
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="Current image" class="h-32 rounded-lg object-cover mb-2 border border-gray-200">
                                @else
                                    <div class="h-32 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 mb-2 border border-gray-200">
                                        No Image
                                    </div>
                                @endif
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Upload New Image (Optional)</label>
                                <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 bg-gray-50">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200">
                                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active (Visible on App)</option>
                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
                                </select>
                            </div>

                            <div class="flex items-center mt-6">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                    Featured Product (Show on homepage top)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="5" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-primary-500/30 transition-all">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
