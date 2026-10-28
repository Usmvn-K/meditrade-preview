<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('vendor.dashboard') }}" class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl flex items-center justify-center text-slate-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-primary-900 leading-tight uppercase tracking-tighter">
                    {{ __('Asset Deployment') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Configure technical specifications for a new inventory unit</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-primary-900 to-secondary-600 px-8 py-10 text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 backdrop-blur-sm">
                            <i class="fa-solid fa-plus-circle text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-black uppercase tracking-tighter">New Asset Protocol</h3>
                        <p class="text-blue-100 mt-2 font-medium">Index a new retail product into the global ecosystem.</p>
                    </div>
                </div>

                <!-- Form Body -->
                <form action="{{ route('vendor.store-service') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8"
                      x-data="serviceCreator()" @submit="handleSubmit($event)">
                    @csrf
                    
                    <!-- Service Title -->
                    <div>
                        <label for="name" class="block text-sm font-black text-slate-700 mb-3 ml-1 uppercase tracking-widest">Asset Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-900/10 focus:bg-white focus:border-primary-900 transition-all text-lg font-bold placeholder-slate-300"
                            placeholder="e.g., Premium Leather Briefcase" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div x-data="{ isOptimizing: false }">
                        <div class="flex justify-between items-center mb-3 ml-1">
                            <label for="description" class="block text-sm font-black text-slate-700 uppercase tracking-widest">Asset Description</label>
                            <button type="button" @click="optimizeWithAI" 
                                    class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 bg-primary-50 text-primary-900 rounded-lg hover:bg-primary-900 hover:text-white transition-all flex items-center gap-2 border border-primary-100"
                                    :disabled="isOptimizing">
                                <i class="fa-solid fa-wand-magic-sparkles" :class="{ 'animate-pulse': isOptimizing }"></i>
                                <span x-text="isOptimizing ? 'NEURAL OPTIMIZING...' : 'NEURAL ASSIST'"></span>
                            </button>
                        </div>
                        <textarea id="description" name="description" rows="5" x-ref="descriptionField"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-900/10 focus:bg-white focus:border-primary-900 transition-all font-medium placeholder-slate-300"
                            placeholder="Describe your asset in detail..." required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Category and Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="category_id" class="block text-sm font-black text-slate-700 mb-3 ml-1 uppercase tracking-widest">Market Category</label>
                            <div class="relative">
                                <select id="category_id" name="category_id"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-900/10 focus:bg-white focus:border-primary-900 transition-all font-bold appearance-none" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>— {{ $child->name }}</option>
                                    @endforeach
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-black text-slate-700 mb-3 ml-1 uppercase tracking-widest">Regional Location</label>
                            <input type="text" id="location" name="location" value="{{ old('location') }}"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-900/10 focus:bg-white focus:border-primary-900 transition-all font-bold placeholder-slate-300"
                                placeholder="e.g., Karachi, Lahore or Global">
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="space-y-12">
                        <div class="bg-primary-900 rounded-[2.5rem] p-8 md:p-12 text-white relative overflow-hidden shadow-2xl">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
                            <div class="relative space-y-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-secondary-500 backdrop-blur-md">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                    <h4 class="text-xl font-black tracking-tight uppercase">Valuation Model</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label for="price" class="block text-sm font-black text-blue-300 mb-3 ml-1 uppercase tracking-widest">Base Price (PKR)</label>
                                        <div class="relative">
                                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-secondary-500 font-black">Rs.</span>
                                            <input type="number" id="price" name="price" step="1" min="0" value="{{ old('price') }}"
                                                class="w-full pl-16 pr-6 py-5 bg-white/5 border border-white/10 rounded-[1.5rem] focus:ring-4 focus:ring-secondary-500/20 focus:bg-white/10 focus:border-secondary-600 transition-all text-2xl font-black text-white" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="price_type" class="block text-sm font-black text-blue-300 mb-3 ml-1 uppercase tracking-widest">Pricing Logic</label>
                                        <div class="relative">
                                            <select id="price_type" name="price_type"
                                                class="w-full px-6 py-5 bg-white/5 border border-white/10 rounded-[1.5rem] focus:ring-4 focus:ring-secondary-500/20 focus:bg-white/10 focus:border-secondary-600 transition-all font-black text-white appearance-none">
                                                <option value="fixed" {{ old('price_type') == 'fixed' ? 'selected' : '' }}>Standard Retail</option>
                                                <option value="per_unit" {{ old('price_type') == 'per_unit' ? 'selected' : '' }}>Per Unit</option>
                                                <option value="bulk" {{ old('price_type') == 'bulk' ? 'selected' : '' }}>Bulk Pricing</option>
                                            </select>
                                            <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-blue-400 pointer-events-none text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Add-ons -->
                        <div class="bg-secondary-50/50 rounded-[2.5rem] p-8 md:p-12 border border-secondary-100/50">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-secondary-600 rounded-xl flex items-center justify-center text-white">
                                        <i class="fa-solid fa-plus-circle"></i>
                                    </div>
                                    <h4 class="text-xl font-black text-primary-900 tracking-tight uppercase">Complementary Assets <span class="text-secondary-600 text-sm ml-2 font-bold">(UPSELL)</span></h4>
                                </div>
                                <button type="button" @click="addons.push({name: '', price: ''})" class="bg-secondary-600 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary-900 transition-all shadow-lg shadow-red-200">
                                    + Add Item
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(addon, index) in addons" :key="index">
                                    <div class="bg-white p-6 rounded-3xl border border-secondary-100 shadow-sm relative group">
                                        <button type="button" @click="addons.splice(index, 1)" class="absolute -top-3 -right-3 w-8 h-8 bg-black text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Asset Name</label>
                                                <input type="text" :name="`add_ons[${index}][name]`" x-model="addon.name" placeholder="e.g., Insurance Coverage" 
                                                    class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:border-secondary-600 transition-all font-bold">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Premium (PKR)</label>
                                                <input type="number" :name="`add_ons[${index}][price]`" x-model="addon.price" placeholder="Extra charge" 
                                                    class="w-full px-4 py-3 bg-slate-50 border border-transparent rounded-xl focus:border-secondary-600 transition-all font-bold">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center text-primary-900">
                                    <i class="fa-solid fa-images"></i>
                                </div>
                                <h4 class="text-xl font-black text-primary-900 tracking-tight uppercase">Media Asset Management</h4>
                            </div>
                            <button type="button" @click="suggestImageIdeas"
                                    class="text-[10px] font-black uppercase tracking-widest px-4 py-2 bg-primary-50 text-primary-900 rounded-xl hover:bg-primary-900 hover:text-white transition-all flex items-center gap-2 border border-primary-100"
                                    :disabled="isGettingSuggestions">
                                <i class="fa-solid fa-lightbulb" :class="{ 'animate-yellow-pulse': isGettingSuggestions }"></i>
                                <span x-text="isGettingSuggestions ? 'ANALYZING...' : 'NEURAL PHOTO IDEAS'"></span>
                            </button>
                        </div>
                        
                        <!-- Main Upload Zone -->
                        <div class="relative group/upload cursor-pointer">
                            <input type="file" id="image-upload" accept="image/*" multiple class="hidden" @change="handleFiles($event)">
                            <label for="image-upload" class="block relative z-10 w-full rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-slate-50/30 p-12 text-center transition-all hover:bg-white hover:border-primary-900 cursor-pointer">
                                <div class="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center mx-auto mb-6 group-hover/upload:scale-110 transition-transform">
                                    <i class="fa-solid fa-cloud-arrow-up text-primary-900 text-2xl"></i>
                                </div>
                                <h5 class="text-lg font-black text-slate-900 mb-2 uppercase tracking-tight">Upload Visual Manifest</h5>
                                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Drop your high-res captures here to build the visual gallery.</p>
                            </label>
                        </div>

                        <!-- Image Previews Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8" x-show="previews.length > 0">
                            <template x-for="(preview, index) in previews" :key="index">
                                <div class="relative group aspect-square rounded-[2rem] overflow-hidden border-2 transition-all duration-500" 
                                     :class="featuredIndex === index ? 'border-primary-900 shadow-xl shadow-primary-900/10' : 'border-slate-100'">
                                    
                                    <img :src="preview.url" class="w-full h-full object-cover">
                                    
                                    <!-- Management Overlay -->
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-3">
                                        <div class="flex justify-end">
                                            <button type="button" @click="removeImage(index)" class="w-8 h-8 bg-black/50 hover:bg-secondary-600 text-white rounded-lg flex items-center justify-center transition-all">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </div>
                                        <button type="button" @click="setFeatured(index)" 
                                                class="w-full py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all"
                                                :class="featuredIndex === index ? 'bg-primary-900 text-white' : 'bg-white text-slate-900 hover:bg-primary-50'">
                                            <span x-text="featuredIndex === index ? 'Master Image' : 'Set as Master'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <input type="hidden" name="featured_image_index" :value="featuredIndex">
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                    </div>

                    <!-- Action Bar -->
                    <div class="pt-10 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
                        <a href="{{ route('vendor.dashboard') }}" class="text-slate-400 hover:text-primary-900 font-black tracking-[0.3em] uppercase text-[10px] transition-colors">
                            Purge Workspace
                        </a>
                        <button type="submit" :disabled="submitting"
                            class="w-full md:w-auto px-12 py-5 bg-gradient-to-r from-primary-900 to-secondary-600 text-white font-black text-lg rounded-[2rem] shadow-2xl shadow-primary-900/30 hover:-translate-y-1 hover:shadow-secondary-600/50 transition-all flex items-center justify-center gap-4 disabled:opacity-70 disabled:cursor-not-allowed uppercase tracking-tighter">
                            <span x-show="!submitting" class="flex items-center gap-4">Authorize Asset Launch <i class="fa-solid fa-rocket"></i></span>
                            <span x-show="submitting" class="flex items-center gap-4">Syncing Ecosystem... <i class="fa-solid fa-circle-notch animate-spin"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function serviceCreator() {
            return {
                submitting: false,
                previews: [], // Array of {file, url}
                featuredIndex: 0,
                dataTransfer: new DataTransfer(),
                packages: [],
                addons: [],
                isOptimizing: false,
                isGettingSuggestions: false,

                suggestImageIdeas() {
                    const name = document.getElementById('name').value;
                    const catSelect = document.getElementById('category_id');
                    const category = catSelect.options[catSelect.selectedIndex].text;

                    if (!name || catSelect.selectedIndex === 0) {
                        alert('Please enter a service title and select a category first.');
                        return;
                    }

                    this.isGettingSuggestions = true;
                    
                    fetch('{{ route("ai.suggest-images") }}', {
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
                            alert('AI Ideas:\n' + data.suggestions.replace(/<[^>]*>/g, ''));
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
                    const category = catSelect.options[catSelect.selectedIndex].text;
                    const description = this.$refs.descriptionField.value;

                    if (!name || catSelect.selectedIndex === 0) {
                        alert('Please enter a service title and select a category first.');
                        return;
                    }

                    this.isOptimizing = true;
                    
                    fetch('{{ route("ai.optimize-description") }}', {
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
                
                handleFiles(event) {
                    const files = Array.from(event.target.files);
                    files.forEach(file => {
                        this.dataTransfer.items.add(file);
                        const url = URL.createObjectURL(file);
                        this.previews.push({ file, url });
                    });
                    event.target.value = '';
                },
                
                removeImage(index) {
                    const item = this.previews[index];
                    if (item.url) URL.revokeObjectURL(item.url);
                    this.previews.splice(index, 1);
                    
                    const newDT = new DataTransfer();
                    this.previews.forEach(p => newDT.items.add(p.file));
                    this.dataTransfer = newDT;

                    if (this.featuredIndex === index) {
                        this.featuredIndex = 0;
                    } else if (this.featuredIndex > index) {
                        this.featuredIndex--;
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
</x-app-layout>
