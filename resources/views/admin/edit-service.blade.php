<x-app-layout>

@push('styles')
<style>
    .edit-form-bg { background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #fefce8 100%); }
    .card-glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border: 1.5px solid #f1f5f9; }
    .input-field { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 1.25rem; padding: 14px 20px; font-weight: 700; font-size: 14px; color: #0f172a; transition: all 0.2s; }
    .input-field:focus { background: white; border-color: #15803d; box-shadow: 0 0 0 4px rgba(21, 128, 61, 0.1); outline: none; }
    .section-title { text-transform: uppercase; font-weight: 900; letter-spacing: -0.02em; color: #052e16; }
    .badge-icon { width: 42px; height: 42px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .btn-gradient { background: linear-gradient(135deg, #052e16, #16a34a); transition: all 0.3s ease; }
    .btn-gradient:hover { background: linear-gradient(135deg, #16a34a, #22c55e); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(21, 128, 61, 0.3); }
    .toggle-checkbox:checked + .toggle-label { background-color: #15803d; }
    .toggle-checkbox:checked + .toggle-label .toggle-dot { transform: translateX(100%); }
</style>
@endpush

<div class="edit-form-bg min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        {{-- Page Navigation Header --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.services') }}" class="w-12 h-12 bg-white hover:bg-emerald-50 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-center text-slate-700 hover:text-emerald-800 transition-all">
                    <i class="fa-solid fa-arrow-left text-base"></i>
                </a>
                <div>
                    <span class="text-[10px] font-black text-emerald-700 uppercase tracking-[0.3em] block">Inventory Management</span>
                    <h1 class="text-3xl font-black text-[#052e16] uppercase tracking-tight leading-none">
                        Edit Product
                    </h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-emerald-100 text-emerald-900 text-xs font-black uppercase tracking-widest rounded-full border border-emerald-200">
                    ID: #{{ $service->id }}
                </span>
            </div>
        </div>

        {{-- Main Form Container --}}
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden"
             x-data="serviceEditor({ 
                 existing: {{ json_encode($service->images ?? ($service->image ? [$service->image] : [])) }},
                 featured: {{ $service->featured_image_index ?? 0 }},
                 storage_url: '{{ asset('storage') }}',
                 packages: {{ json_encode($service->packages ?? []) }},
                 addons: {{ json_encode($service->add_ons ?? []) }}
             })" @submit="handleSubmit($event)">

            {{-- Form Header Banner --}}
            <div class="bg-gradient-to-r from-[#052e16] via-[#14532d] to-[#16a34a] p-8 sm:p-12 text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 w-80 h-80 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md text-amber-300">
                                <i class="fa-solid fa-pen-to-square text-xl"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-[0.25em] text-emerald-200">Gohar Mart Catalog</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black uppercase tracking-tight leading-tight">
                            {{ $service->name }}
                        </h2>
                        <p class="text-xs font-medium text-emerald-100/80 mt-1">Modify pricing, image assets, descriptions and product options below.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 shrink-0">
                        <span class="text-[9px] font-black text-emerald-200 uppercase tracking-widest block mb-1">Current Retail Price</span>
                        <div class="text-2xl font-black text-white">PKR {{ number_format($service->getCurrentPrice()) }}</div>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-12 space-y-12">
                @csrf
                @method('PUT')

                {{-- ===== SECTION 1: BASIC INFORMATION ===== --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                        <div class="badge-icon bg-emerald-50 text-emerald-800">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                        <div>
                            <h3 class="text-lg section-title">Basic Information</h3>
                            <p class="text-xs text-slate-400 font-bold">Product name, categories, brand, and description</p>
                        </div>
                    </div>

                    {{-- Product Name --}}
                    <div>
                        <label for="name" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                            Product Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}"
                               class="w-full input-field"
                               placeholder="e.g. StamanX 1000mg Herbal Capsules" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Category, Sub Category, Brand, Unit --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        {{-- Category --}}
                        <div>
                            <label for="category_id" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                                Category
                            </label>
                            <select id="category_id" name="category_id" class="w-full input-field">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sub Category --}}
                        <div>
                            <label for="sub_category" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                                Sub Category
                            </label>
                            <input type="text" id="sub_category" name="sub_category" value="{{ old('sub_category', $service->sub_category) }}"
                                   class="w-full input-field" placeholder="e.g. Capsules">
                        </div>

                        {{-- Brand --}}
                        <div>
                            <label for="brand" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                                Brand
                            </label>
                            <select id="brand" name="brand" class="w-full input-field">
                                <option value="">Select Brand</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b->name }}" {{ old('brand', $service->brand) == $b->name ? 'selected' : '' }}>
                                        {{ $b->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Unit --}}
                        <div>
                            <label for="unit" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                                Unit Measurement
                            </label>
                            <input type="text" id="unit" name="unit" value="{{ old('unit', $service->unit) }}"
                                   class="w-full input-field" placeholder="e.g. Pack of 60">
                        </div>
                    </div>

                    {{-- Short Description --}}
                    <div>
                        <label for="short_description" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                            Short Summary (Subtitle)
                        </label>
                        <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $service->short_description) }}"
                               class="w-full input-field" placeholder="Brief 1-line product summary">
                    </div>

                    {{-- Full Description with AI Assist --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="description" class="block text-xs font-black text-slate-700 uppercase tracking-widest">
                                Full Product Description <span class="text-red-500">*</span>
                            </label>
                            <button type="button" @click="optimizeWithAI" 
                                    class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 bg-emerald-50 text-emerald-800 rounded-xl hover:bg-emerald-100 transition-all flex items-center gap-2 border border-emerald-200"
                                    :disabled="isOptimizing">
                                <i class="fa-solid fa-wand-magic-sparkles text-amber-500" :class="{ 'animate-spin': isOptimizing }"></i>
                                <span x-text="isOptimizing ? 'AI OPTIMIZING...' : '✨ AI ASSIST'"></span>
                            </button>
                        </div>
                        <textarea id="description" name="description" rows="5" x-ref="descriptionField"
                                  class="w-full input-field leading-relaxed"
                                  placeholder="Describe your product in detail..." required>{{ old('description', $service->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                {{-- ===== SECTION 2: PRICING & DISCOUNTS ===== --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                        <div class="badge-icon bg-amber-50 text-amber-600">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div>
                            <h3 class="text-lg section-title">Pricing & Sale Settings</h3>
                            <p class="text-xs text-slate-400 font-bold">Standard price, sale price, discounts and pricing protocol</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Regular Price --}}
                        <div>
                            <label for="price" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                                Regular Price (PKR) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-emerald-800 text-sm">Rs.</span>
                                <input type="number" id="price" name="price" step="1" min="0" value="{{ old('price', $service->price) }}"
                                       class="w-full input-field pl-12" required>
                            </div>
                        </div>

                        {{-- Sale Price --}}
                        <div>
                            <label for="sale_price" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                                Sale Price (PKR)
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-red-600 text-sm">Rs.</span>
                                <input type="number" id="sale_price" name="sale_price" step="1" min="0" value="{{ old('sale_price', $service->sale_price) }}"
                                       class="w-full input-field pl-12" placeholder="Discounted price">
                            </div>
                        </div>

                        {{-- Promotional Discount % --}}
                        <div>
                            <label for="promotional_discount" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
                                Promotional Discount (%)
                            </label>
                            <input type="number" id="promotional_discount" name="promotional_discount" step="0.1" min="0" max="100" value="{{ old('promotional_discount', $service->promotional_discount) }}"
                                   class="w-full input-field" placeholder="e.g. 15">
                        </div>
                    </div>

                    {{-- Toggles: On Sale, Featured, Best Seller, New Arrival --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-2">
                        <label class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-100 rounded-2xl cursor-pointer hover:bg-emerald-50/50 transition-all">
                            <input type="checkbox" name="is_on_sale" value="1" {{ old('is_on_sale', $service->is_on_sale) ? 'checked' : '' }} class="w-5 h-5 rounded-lg text-emerald-700 focus:ring-0">
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">🏷️ On Sale</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-100 rounded-2xl cursor-pointer hover:bg-emerald-50/50 transition-all">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }} class="w-5 h-5 rounded-lg text-emerald-700 focus:ring-0">
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">⭐ Featured Item</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-100 rounded-2xl cursor-pointer hover:bg-emerald-50/50 transition-all">
                            <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller', $service->is_best_seller) ? 'checked' : '' }} class="w-5 h-5 rounded-lg text-emerald-700 focus:ring-0">
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">🔥 Best Seller</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-100 rounded-2xl cursor-pointer hover:bg-emerald-50/50 transition-all">
                            <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $service->is_new_arrival) ? 'checked' : '' }} class="w-5 h-5 rounded-lg text-emerald-700 focus:ring-0">
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">✨ New Arrival</span>
                        </label>
                    </div>
                </div>

                {{-- ===== SECTION 3: VISUAL ASSETS & IMAGES ===== --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="badge-icon bg-blue-50 text-blue-600">
                                <i class="fa-solid fa-images"></i>
                            </div>
                            <div>
                                <h3 class="text-lg section-title">Product Image Assets</h3>
                                <p class="text-xs text-slate-400 font-bold">Upload high quality product photos & pick featured image</p>
                            </div>
                        </div>
                        <button type="button" @click="suggestImageIdeas"
                                class="text-[10px] font-black uppercase tracking-widest px-4 py-2 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-100 transition-all flex items-center gap-2 border border-purple-100"
                                :disabled="isGettingSuggestions">
                            <i class="fa-solid fa-lightbulb text-amber-500" :class="{ 'animate-pulse': isGettingSuggestions }"></i>
                            <span x-text="isGettingSuggestions ? 'ANALYZING...' : 'AI PHOTO IDEAS'"></span>
                        </button>
                    </div>

                    {{-- AI Suggestions Modal/Box --}}
                    <div x-show="imageSuggestions" x-transition class="bg-[#052e16] rounded-3xl p-6 text-white relative overflow-hidden shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-wand-magic-sparkles text-amber-400"></i>
                                <h5 class="text-xs font-black uppercase tracking-[0.2em]">AI Photo Recommendations</h5>
                            </div>
                            <button type="button" @click="imageSuggestions = null" class="text-white/50 hover:text-white transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="prose prose-invert text-xs leading-relaxed font-medium text-emerald-100" x-html="imageSuggestions"></div>
                    </div>

                    {{-- Upload Dropzone --}}
                    <div class="relative group/upload cursor-pointer">
                        <input type="file" id="image-upload" accept="image/*" multiple class="hidden" @change="handleNewFiles($event)">
                        <label for="image-upload" class="block relative z-10 w-full rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50/50 p-10 text-center transition-all hover:bg-white hover:border-emerald-500 cursor-pointer">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-md flex items-center justify-center mx-auto mb-4 group-hover/upload:scale-110 transition-transform">
                                <i class="fa-solid fa-cloud-arrow-up text-emerald-700 text-2xl"></i>
                            </div>
                            <h5 class="text-base font-black text-slate-900 mb-1 uppercase tracking-tight">Click or Drag Product Images</h5>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">PNG, JPG, WEBP formats allowed</p>
                        </label>
                    </div>

                    {{-- Image Gallery Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        {{-- Existing Images --}}
                        <template x-for="(img, index) in existingImages" :key="'existing-'+index">
                            <div class="relative group aspect-square rounded-2xl overflow-hidden border-2 transition-all duration-300 shadow-sm"
                                 :class="[
                                    featuredIndex === index ? 'border-emerald-600 shadow-emerald-900/20' : 'border-slate-100',
                                    removedIndices.includes(index) ? 'opacity-20 grayscale scale-90' : 'opacity-100'
                                 ]">
                                <img :src="storageUrl + '/' + img" class="w-full h-full object-cover">
                                
                                <div class="absolute inset-0 bg-slate-950/70 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-3" x-show="!removedIndices.includes(index)">
                                    <div class="flex justify-end">
                                        <button type="button" @click="toggleRemove(index)" class="w-8 h-8 bg-red-600/80 hover:bg-red-600 text-white rounded-lg flex items-center justify-center transition-all" title="Remove">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                    <button type="button" @click="setFeatured(index)" 
                                            class="w-full py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all"
                                            :class="featuredIndex === index ? 'bg-emerald-600 text-white' : 'bg-white text-slate-900 hover:bg-emerald-50'">
                                        <span x-text="featuredIndex === index ? '★ Main Image' : 'Set as Main'"></span>
                                    </button>
                                </div>

                                <div x-show="removedIndices.includes(index)" class="absolute inset-0 flex items-center justify-center bg-red-500/20">
                                    <button type="button" @click="toggleRemove(index)" class="bg-white text-red-600 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase shadow-lg">
                                        Restore
                                    </button>
                                </div>

                                <div x-show="featuredIndex === index && !removedIndices.includes(index)" class="absolute top-2 left-2 bg-emerald-600 text-white w-6 h-6 rounded-lg flex items-center justify-center text-xs shadow-md">
                                    <i class="fa-solid fa-star"></i>
                                </div>

                                <template x-if="removedIndices.includes(index)">
                                    <input type="hidden" name="removed_indices[]" :value="index">
                                </template>
                            </div>
                        </template>

                        {{-- New Upload Previews --}}
                        <template x-for="(preview, idx) in previews" :key="'new-'+idx">
                            <div class="relative group aspect-square rounded-2xl overflow-hidden border-2 border-emerald-300 shadow-sm">
                                <img :src="preview.url" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-slate-950/60 flex flex-col justify-between p-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="flex justify-end">
                                        <button type="button" @click="removeNewImage(idx)" class="w-8 h-8 bg-red-600 text-white rounded-lg flex items-center justify-center">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </div>
                                    <span class="bg-emerald-600 text-white text-[9px] font-black text-center py-1.5 rounded-xl uppercase tracking-widest">New Photo</span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <input type="hidden" name="featured_image_index" id="featured_image_index_input" value="{{ $service->featured_image_index ?? 0 }}" :value="featuredIndex" x-effect="$el.value = featuredIndex">
                    <x-input-error :messages="$errors->get('images')" class="mt-2" />
                </div>

                {{-- ===== SECTION 4: TIERED PACKAGES & ADD-ONS ===== --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="badge-icon bg-purple-50 text-purple-600">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <div>
                                <h3 class="text-lg section-title">Packages & Add-Ons</h3>
                                <p class="text-xs text-slate-400 font-bold">Custom bundle tiers and optional upsell items</p>
                            </div>
                        </div>
                    </div>

                    {{-- Packages List --}}
                    <div class="bg-slate-50/70 p-6 rounded-3xl border border-slate-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">📦 Tiered Package Variations</span>
                            <button type="button" @click="addPackage()" class="bg-emerald-700 text-white px-4 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-800 transition-all">
                                + Add Tier
                            </button>
                        </div>
                        <template x-for="(pkg, index) in packages" :key="index">
                            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm relative group grid grid-cols-1 md:grid-cols-3 gap-4">
                                <button type="button" @click="removePackage(index)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-md">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                                <div>
                                    <input type="text" :name="`packages[${index}][name]`" x-model="pkg.name" placeholder="Tier Name (e.g. Pack of 3)" class="w-full input-field py-2 text-xs">
                                </div>
                                <div>
                                    <input type="number" :name="`packages[${index}][price]`" x-model="pkg.price" placeholder="Price (PKR)" class="w-full input-field py-2 text-xs">
                                </div>
                                <div>
                                    <input type="text" :name="`packages[${index}][description]`" x-model="pkg.description" placeholder="Short detail" class="w-full input-field py-2 text-xs">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- ===== STICKY ACTION BAR ===== --}}
                <div class="pt-8 border-t border-slate-100 flex items-center justify-between gap-4">
                    <a href="{{ route('admin.services') }}" class="px-6 py-4 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-black text-xs uppercase tracking-widest transition-colors">
                        Cancel
                    </a>
                    <button type="submit" :disabled="submitting"
                            class="btn-gradient text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-lg flex items-center gap-3 disabled:opacity-50">
                        <span x-show="!submitting" class="flex items-center gap-2"><i class="fa-solid fa-check"></i> Save Product Changes</span>
                        <span x-show="submitting" class="flex items-center gap-2"><i class="fa-solid fa-circle-notch animate-spin"></i> Saving...</span>
                    </button>
                </div>

            </form>
        </div>

        {{-- Danger Zone: Terminate Product --}}
        <div class="mt-10 bg-white rounded-3xl p-8 border border-red-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h4 class="text-sm font-black text-red-700 uppercase tracking-widest">Delete Product</h4>
                <p class="text-xs text-slate-400 font-medium">Permanently delete this item and clean up related images.</p>
            </div>
            <form action="{{ route('admin.services.delete', $service) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-sm">
                    <i class="fa-solid fa-trash-can mr-1"></i> Delete Item
                </button>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function serviceEditor(data) {
        return {
            submitting: false,
            existingImages: data.existing,
            removedIndices: [],
            previews: [],
            featuredIndex: data.featured,
            storageUrl: data.storage_url,
            packages: data.packages,
            addons: data.addons,
            dataTransfer: new DataTransfer(),
            isOptimizing: false,
            isGettingSuggestions: false,
            imageSuggestions: null,

            suggestImageIdeas() {
                const name = document.getElementById('name').value;
                const catSelect = document.getElementById('category_id');
                const category = catSelect.options[catSelect.selectedIndex] ? catSelect.options[catSelect.selectedIndex].text : '';

                if (!name) {
                    alert('Please enter a product title first.');
                    return;
                }

                this.isGettingSuggestions = true;
                this.imageSuggestions = null;
                
                fetch('{{ route("admin.ai.suggest-images") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name, category })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.imageSuggestions = data.suggestions;
                    } else {
                        alert(data.message || 'AI Suggestions failed.');
                    }
                })
                .catch(e => {
                    alert('An error occurred during AI analysis.');
                })
                .finally(() => {
                    this.isGettingSuggestions = false;
                });
            },

            optimizeWithAI() {
                const name = document.getElementById('name').value;
                const catSelect = document.getElementById('category_id');
                const category = catSelect.options[catSelect.selectedIndex] ? catSelect.options[catSelect.selectedIndex].text : '';
                const description = this.$refs.descriptionField.value;

                if (!name) {
                    alert('Please enter a product title first.');
                    return;
                }

                this.isOptimizing = true;
                
                fetch('{{ route("admin.ai.optimize-description") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name, category, description })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.$refs.descriptionField.value = data.optimized_text;
                    } else {
                        alert(data.message || 'AI Optimization failed.');
                    }
                })
                .catch(e => {
                    alert('An error occurred during AI optimization.');
                })
                .finally(() => {
                    this.isOptimizing = false;
                });
            },

            addPackage() {
                this.packages.push({ name: '', price: '', description: '' });
            },

            removePackage(index) {
                this.packages.splice(index, 1);
            },

            addAddOn() {
                this.addons.push({ name: '', price: '' });
            },

            removeAddOn(index) {
                this.addons.splice(index, 1);
            },
            
            handleNewFiles(event) {
                const files = Array.from(event.target.files);
                files.forEach(file => {
                    this.dataTransfer.items.add(file);
                    const url = URL.createObjectURL(file);
                    this.previews.push({ file, url });
                });
                event.target.value = '';
            },
            
            removeNewImage(index) {
                const item = this.previews[index];
                if (item.url) URL.revokeObjectURL(item.url);
                this.previews.splice(index, 1);
                
                const newDT = new DataTransfer();
                this.previews.forEach(p => newDT.items.add(p.file));
                this.dataTransfer = newDT;
            },
            
            toggleRemove(index) {
                if (this.removedIndices.includes(index)) {
                    this.removedIndices = this.removedIndices.filter(i => i !== index);
                } else {
                    this.removedIndices.push(index);
                    if (this.featuredIndex === index) {
                        this.featuredIndex = 0;
                    }
                }
            },
            
            setFeatured(index) {
                this.featuredIndex = index;
            },

            handleSubmit(event) {
                this.submitting = true;
                const form = event.target;
                const finalInput = document.createElement('input');
                finalInput.type = 'file';
                finalInput.name = 'images[]';
                finalInput.multiple = true;
                finalInput.files = this.dataTransfer.files;
                finalInput.style.display = 'none';
                form.appendChild(finalInput);
            }
        }
    }
</script>
@endpush

</x-app-layout>
