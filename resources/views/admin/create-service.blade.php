<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-2 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                PRODUCTS / <span class="text-primary-600">ADD PRODUCT</span>
            </div>
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Add New Product</h2>
                    <p class="text-sm text-gray-500 mt-1 uppercase text-xs font-semibold tracking-wider">Add a new item to your store catalog.</p>
                </div>
                <a href="{{ route('admin.services') }}" class="flex items-center text-sm font-semibold text-gray-600 bg-white border border-gray-300 rounded-lg px-4 py-2 hover:bg-gray-50 shadow-sm transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    BACK TO REGISTRY
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                <input type="hidden" name="status" value="active" id="statusInput">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    
                    <!-- Left Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Product Information -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-8 h-8 rounded-full border-2 border-gray-200 flex items-center justify-center mr-3">
                                    <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 uppercase">Product Information</h3>
                                    <p class="text-xs text-gray-500">Basic details and categorization.</p>
                                </div>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <label for="name" class="block text-xs font-bold text-gray-400 uppercase mb-1">Product Name</label>
                                    <input type="text" name="name" id="name" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition px-4 py-3 text-sm" placeholder="Enter product name" value="{{ old('name') }}">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="category_id" class="block text-xs font-bold text-gray-400 uppercase mb-1">Category</label>
                                        <select name="category_id" id="category_id" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition px-4 py-3 text-sm appearance-none" onchange="filterSubCategories()">
                                            <option value="">Select Category...</option>
                                            @if(isset($categories))
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div>
                                        <label for="sub_category" class="block text-xs font-bold text-gray-400 uppercase mb-1">Sub Category</label>
                                        <select name="sub_category" id="sub_category" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition px-4 py-3 text-sm appearance-none">
                                            <option value="">Select Sub Category...</option>
                                            @if(isset($subCategories))
                                                @foreach($subCategories as $sub)
                                                    <option value="{{ $sub->name }}" data-parent="{{ $sub->parent_id }}" {{ old('sub_category') == $sub->name ? 'selected' : '' }}>{{ $sub->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div>
                                        <label for="brand" class="block text-xs font-bold text-gray-400 uppercase mb-1">Brand</label>
                                        <select name="brand" id="brand" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition px-4 py-3 text-sm appearance-none">
                                            <option value="">Select Brand...</option>
                                            @if(isset($brands))
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->name }}" {{ old('brand') == $brand->name ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="unit" class="block text-xs font-bold text-gray-400 uppercase mb-1">Unit (UOM)</label>
                                    <select name="unit" id="unit" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition px-4 py-3 text-sm appearance-none">
                                        <option value="">Select Unit...</option>
                                        @if(isset($units))
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->symbol }}" {{ old('unit') == $unit->symbol ? 'selected' : '' }}>{{ $unit->name }} ({{ $unit->symbol }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration Protocol -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase mb-3 px-1">Configuration Protocol</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="cursor-pointer border-2 border-yellow-400 bg-yellow-50 rounded-xl p-4 flex flex-col relative">
                                    <input type="radio" name="protocol" value="simple" class="absolute opacity-0" checked>
                                    <div class="flex items-center mb-2 text-yellow-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <span class="font-bold text-gray-900 mb-1">Simple Formulation</span>
                                    <span class="text-xs text-gray-500">Standalone product with fixed sartorial attributes. Ideal for standard retail inventory.</span>
                                </label>

                                <label class="cursor-pointer border-2 border-transparent hover:border-gray-200 bg-white rounded-xl p-4 flex flex-col transition">
                                    <input type="radio" name="protocol" value="adaptive" class="absolute opacity-0">
                                    <div class="flex items-center mb-2 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <span class="font-bold text-gray-900 mb-1">Adaptive Protocol</span>
                                    <span class="text-xs text-gray-500">Dynamic formulation with multiple states (Size, Texture, or Volume variations).</span>
                                </label>
                            </div>
                        </div>

                        <!-- Pricing Box -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                                <div>
                                    <div class="flex items-center mb-1">
                                        <label for="website_price" class="block text-xs font-bold text-gray-400 uppercase mr-2">Website Price</label>
                                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded">Website</span>
                                    </div>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3 text-blue-600 font-bold text-sm">PKR</span>
                                        <input type="number" step="0.01" name="website_price" id="website_price" class="w-full rounded-xl border-none bg-gray-50 focus:bg-white focus:ring focus:ring-primary-200 transition pl-12 pr-4 py-3 text-sm font-semibold text-gray-700" placeholder="0.00" value="{{ old('website_price') }}">
                                        <!-- Keep legacy required fields populated via hidden or set defaults if needed, or map them -->
                                        <input type="hidden" name="price" id="price" value="0" x-model="document.getElementById('website_price').value">
                                    </div>
                                </div>

                                <div>
                                    <label for="promotional_discount" class="block text-xs font-bold text-gray-400 uppercase mb-1">Promotional Discount</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3 text-red-500 font-bold text-sm">PKR</span>
                                        <input type="number" step="0.01" name="promotional_discount" id="promotional_discount" class="w-full rounded-xl border-none bg-gray-50 focus:bg-white focus:ring focus:ring-primary-200 transition pl-12 pr-4 py-3 text-sm font-semibold text-gray-700" placeholder="Optional" value="{{ old('promotional_discount') }}">
                                        <input type="hidden" name="sale_price" id="sale_price" value="" x-model="document.getElementById('promotional_discount').value">
                                    </div>
                                </div>

                                <div>
                                    <label for="purchase_price" class="block text-xs font-bold text-gray-400 uppercase mb-1">Purchase Price</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3 text-gray-500 font-bold text-sm">PKR</span>
                                        <input type="number" step="0.01" name="purchase_price" id="purchase_price" class="w-full rounded-xl border-none bg-gray-50 focus:bg-white focus:ring focus:ring-primary-200 transition pl-12 pr-4 py-3 text-sm font-semibold text-gray-700" placeholder="0.00" value="{{ old('purchase_price') }}">
                                        <!-- Keep stock mapped if needed -->
                                        <input type="hidden" name="stock_quantity" value="10"> 
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Main Content -->
                    <div class="space-y-6">
                        
                        <!-- Product Thumbnail -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase mb-2 px-1">Product Thumbnail</h3>
                            <div class="bg-white border-2 border-dashed border-indigo-200 rounded-2xl h-56 flex flex-col items-center justify-center relative hover:bg-indigo-50/50 transition overflow-hidden">
                                <input type="file" name="image" id="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewThumbnail(event)">
                                <div id="thumbnail-placeholder" class="text-center">
                                    <span class="text-indigo-600 font-bold text-sm">Click to upload image</span>
                                </div>
                                <img id="thumbnail-preview" class="hidden absolute inset-0 w-full h-full object-cover">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Tabs -->
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-1 rounded-full shadow-sm border border-gray-100 flex space-x-1">

                        <button type="button" class="bg-indigo-50 text-indigo-700 px-6 py-2.5 rounded-full text-xs font-bold uppercase shadow-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            Website Details
                        </button>
                    </div>
                </div>

                <!-- Website Details Content -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-6">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Website Details</h3>
                            <p class="text-sm text-gray-500">Visibility on online store.</p>
                        </div>
                        <div class="flex items-center bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 cursor-pointer" onclick="document.getElementById('statusCheckbox').click()">
                            <span class="text-xs font-bold uppercase text-gray-700 mr-3">Active on web</span>
                            <input type="checkbox" id="statusCheckbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" onchange="document.getElementById('statusInput').value = this.checked ? 'active' : 'inactive'">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Product Gallery -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Product Gallery</label>
                            <div class="border-2 border-dashed border-blue-100 bg-blue-50/30 rounded-2xl h-40 flex items-center justify-center relative hover:bg-blue-50 transition">
                                <input type="file" name="images[]" id="images" accept="image/*" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <span class="text-blue-600 font-bold text-sm">+ Add multiple gallery images</span>
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Short Description</label>
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <div class="bg-gray-50 border-b border-gray-200 p-2 flex items-center space-x-2">
                                    <select class="text-sm border-none bg-transparent text-gray-700 focus:ring-0 py-1"><option>Paragraph</option></select>
                                    <div class="w-px h-4 bg-gray-300"></div>
                                    <button type="button" class="p-1 text-gray-600 hover:text-gray-900"><strong class="font-serif">B</strong></button>
                                    <button type="button" class="p-1 text-gray-600 hover:text-gray-900"><em class="font-serif">I</em></button>
                                    <div class="w-px h-4 bg-gray-300"></div>
                                    <button type="button" class="p-1 text-gray-600 hover:text-gray-900"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></button>
                                    <button type="button" class="p-1 text-gray-600 hover:text-gray-900"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></button>
                                </div>
                                <textarea name="short_description" rows="3" class="w-full border-none focus:ring-0 p-4 text-sm">{{ old('short_description') }}</textarea>
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Product Description</label>
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <div class="bg-gray-50 border-b border-gray-200 p-2 flex items-center space-x-2">
                                    <select class="text-sm border-none bg-transparent text-gray-700 focus:ring-0 py-1"><option>Paragraph</option></select>
                                    <div class="w-px h-4 bg-gray-300"></div>
                                    <button type="button" class="p-1 text-gray-600 hover:text-gray-900"><strong class="font-serif">B</strong></button>
                                    <button type="button" class="p-1 text-gray-600 hover:text-gray-900"><em class="font-serif">I</em></button>
                                    <div class="w-px h-4 bg-gray-300"></div>
                                    <button type="button" class="p-1 text-gray-600 hover:text-gray-900"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></button>
                                    <button type="button" class="p-1 text-gray-600 hover:text-gray-900"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></button>
                                </div>
                                <textarea name="description" rows="5" class="w-full border-none focus:ring-0 p-4 text-sm" required>{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <!-- Toggles -->
                        <div class="bg-gray-50 rounded-xl p-4 flex flex-wrap gap-6 items-center">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2" {{ old('is_featured') ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-gray-700 uppercase">Featured Product</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_best_seller" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2" {{ old('is_best_seller') ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-gray-700 uppercase">Best Seller Product</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_new_arrival" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2" {{ old('is_new_arrival') ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-gray-700 uppercase">New Arrival</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-500 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 uppercase">Related Products</h3>
                            <p class="text-xs text-gray-500">Select products to recommend to customers.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <div class="relative mb-6">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border-none border-b border-gray-200 bg-transparent text-sm placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500" placeholder="Search products...">
                        </div>

                        <div class="h-40 flex flex-col items-center justify-center text-center">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-700">No products selected yet.</p>
                            <p class="text-xs text-gray-400 mt-1">Use the search bar above to add complementary items.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-8">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-12 rounded-2xl w-full shadow-lg shadow-indigo-200 transition-all text-sm tracking-widest uppercase">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewThumbnail(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('thumbnail-preview');
                    const placeholder = document.getElementById('thumbnail-placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Sync inputs for required controller fields
        document.getElementById('productForm').addEventListener('submit', function(e) {
            document.getElementById('price').value = document.getElementById('website_price').value || 0;
            document.getElementById('sale_price').value = document.getElementById('promotional_discount').value || '';
        });

        // Filter sub-categories based on selected parent category
        function filterSubCategories() {
            const categoryId = document.getElementById('category_id').value;
            const subSelect = document.getElementById('sub_category');
            const options = subSelect.querySelectorAll('option[data-parent]');

            options.forEach(option => {
                if (!categoryId || option.getAttribute('data-parent') === categoryId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                    if (option.selected) option.selected = false;
                }
            });

            // Reset selection if current is hidden
            if (subSelect.selectedOptions[0] && subSelect.selectedOptions[0].style.display === 'none') {
                subSelect.value = '';
            }
        }

        // Run on page load to apply initial filter
        document.addEventListener('DOMContentLoaded', filterSubCategories);
    </script>
</x-app-layout>