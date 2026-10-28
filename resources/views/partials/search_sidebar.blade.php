@php
    $facetClone1 = clone $facetQuery;
    $uniqueLocations = $facetClone1->pluck('location')->filter()->unique();

    $facetClone2 = clone $facetQuery;
    $uniqueCategoryIds = $facetClone2->pluck('category_id')->filter()->unique();
    $uniqueCategories = \App\Models\ServiceCategory::whereIn('id', $uniqueCategoryIds)->pluck('name')->filter()->unique();
@endphp

<div class="space-y-6">
    <!-- Price Range Card -->
    <div x-data="{
        minVal: {{ request('min_price', 0) }},
        maxVal: {{ request('max_price', 500000) }},
        minLimit: 0,
        maxLimit: 500000,
        get minPercent() { return (this.minVal / this.maxLimit) * 100; },
        get maxPercent() { return (this.maxVal / this.maxLimit) * 100; },
        formatPrice(val) {
            if(val >= 100000) return (val/100000).toFixed(val%100000===0?0:1) + 'L';
            if(val >= 1000) return (val/1000).toFixed(val%1000===0?0:0) + 'K';
            return val;
        },
        applyFilter() {
            const url = new URL(window.location.href);
            url.searchParams.set('min_price', this.minVal);
            url.searchParams.set('max_price', this.maxVal);
            updateResults(url.toString());
        }
    }">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 block">Price Range (Rs.)</label>

        <!-- Price Display -->
        <div class="flex justify-between items-center mb-4">
            <div class="bg-primary-50 border border-primary-100 rounded-xl px-3 py-2 text-center">
                <p class="text-[8px] font-bold text-primary-400 uppercase tracking-wider mb-0.5">Min</p>
                <p class="text-xs font-black text-primary-900">Rs. <span x-text="formatPrice(minVal)"></span></p>
            </div>
            <div class="text-slate-300 text-xs font-bold">—</div>
            <div class="bg-primary-50 border border-primary-100 rounded-xl px-3 py-2 text-center">
                <p class="text-[8px] font-bold text-primary-400 uppercase tracking-wider mb-0.5">Max</p>
                <p class="text-xs font-black text-primary-900">Rs. <span x-text="formatPrice(maxVal)"></span></p>
            </div>
        </div>

        <!-- Dual Range Slider -->
        <div class="relative h-5 mb-4">
            <div class="absolute top-1/2 -translate-y-1/2 w-full h-1.5 bg-slate-200 rounded-full"></div>
            <div class="absolute top-1/2 -translate-y-1/2 h-1.5 bg-primary-600 rounded-full"
                 :style="'left:' + minPercent + '%;width:' + (maxPercent - minPercent) + '%'"></div>
            <input type="range" :min="minLimit" :max="maxLimit" step="1000"
                   x-model.number="minVal"
                   @input="if(minVal > maxVal - 1000) minVal = maxVal - 1000"
                   class="absolute w-full appearance-none bg-transparent h-1.5 top-1/2 -translate-y-1/2 pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-primary-600 [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:cursor-pointer">
            <input type="range" :min="minLimit" :max="maxLimit" step="1000"
                   x-model.number="maxVal"
                   @input="if(maxVal < minVal + 1000) maxVal = minVal + 1000"
                   class="absolute w-full appearance-none bg-transparent h-1.5 top-1/2 -translate-y-1/2 pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-primary-600 [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:cursor-pointer">
        </div>

        <!-- Quick Presets -->
        <div class="flex flex-wrap gap-1.5 mb-4">
            <button type="button" @click="minVal=0; maxVal=5000" class="text-[9px] font-bold px-2 py-1 rounded-lg border border-slate-200 text-slate-500 hover:border-primary-600 hover:text-primary-600 transition-colors">Under 5K</button>
            <button type="button" @click="minVal=5000; maxVal=20000" class="text-[9px] font-bold px-2 py-1 rounded-lg border border-slate-200 text-slate-500 hover:border-primary-600 hover:text-primary-600 transition-colors">5K-20K</button>
            <button type="button" @click="minVal=20000; maxVal=100000" class="text-[9px] font-bold px-2 py-1 rounded-lg border border-slate-200 text-slate-500 hover:border-primary-600 hover:text-primary-600 transition-colors">20K-1L</button>
        </div>

        <button @click="applyFilter()" class="w-full py-2 bg-primary-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-secondary-600 transition-colors">
            Apply Filter
        </button>
    </div>

    <div class="h-px bg-gray-100 my-6"></div>

    <!-- Product Details Filter -->
    <div>
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Product Details</label>
        
        @if($uniqueLocations->isNotEmpty())
            <div class="mt-4 mb-2 text-[9px] font-bold text-primary-600 uppercase tracking-widest">Store Locations</div>
            <div class="space-y-3 max-h-40 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-200">
                @foreach($uniqueLocations as $loc)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="locations[]" value="{{ $loc }}" onchange="syncAndFilter(this)" class="checked:bg-primary-600 rounded text-primary-600 focus:ring-0 w-4 h-4 border-gray-300 shadow-sm transition-colors cursor-pointer" {{ (is_array(request('locations')) && in_array($loc, request('locations'))) ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-600 group-hover:text-primary-900 transition-colors truncate" title="{{ $loc }}">{{ Str::limit($loc, 25) }}</span>
                    </label>
                @endforeach
            </div>
        @endif

        @if($uniqueCategories->isNotEmpty())
            <div class="mt-4 mb-2 text-[9px] font-bold text-primary-600 uppercase tracking-widest">Categories</div>
            <div class="space-y-3 max-h-40 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-200">
                @foreach($uniqueCategories as $catName)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="categories[]" value="{{ $catName }}" onchange="syncAndFilter(this)" class="checked:bg-primary-600 rounded text-primary-600 focus:ring-0 w-4 h-4 border-gray-300 shadow-sm transition-colors cursor-pointer" {{ (is_array(request('categories')) && in_array($catName, request('categories'))) ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-600 group-hover:text-primary-900 transition-colors truncate" title="{{ $catName }}">{{ Str::limit($catName, 25) }}</span>
                    </label>
                @endforeach
            </div>
        @endif
        
    </div>

    <div class="h-px bg-gray-100 my-6"></div>

    <!-- Rating Filter -->
    <div>
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Customer Reviews</label>
        <div class="mt-2 space-y-2">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="rating_filter" value="4.5" 
                       {{ request('rating') == '4.5' ? 'checked' : '' }}
                       onchange="
                            const url = new URL(window.location.href);
                            url.searchParams.set('rating', '4.5');
                            updateResults(url.toString());
                       "
                       class="checked:bg-primary-600 rounded-full text-primary-600 focus:ring-0 w-4 h-4 border-gray-300">
                <div class="flex items-center gap-1 text-xs font-bold text-gray-600 group-hover:text-primary-900">
                    <span>Excellent</span>
                    <span class="bg-primary-900 text-white text-[9px] px-1.5 py-0.5 rounded ml-1">4.5+</span>
                </div>
            </label>
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="rating_filter" value="4.0"
                       {{ request('rating') == '4.0' ? 'checked' : '' }}
                       onchange="
                            const url = new URL(window.location.href);
                            url.searchParams.set('rating', '4.0');
                            updateResults(url.toString());
                       "
                       class="checked:bg-primary-600 rounded-full text-primary-600 focus:ring-0 w-4 h-4 border-gray-300">
                <div class="flex items-center gap-1 text-xs font-bold text-gray-600 group-hover:text-primary-900">
                    <span>Very Good</span>
                    <span class="bg-primary-900 text-white text-[9px] px-1.5 py-0.5 rounded ml-1">4.0+</span>
                </div>
            </label>
        </div>
    </div>
</div>
