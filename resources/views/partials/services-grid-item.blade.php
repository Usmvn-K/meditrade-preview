<div class="group relative bg-white rounded-3xl overflow-hidden shadow-md shadow-emerald-950/5 hover:shadow-2xl hover:shadow-emerald-900/15 transition-all duration-500 border border-emerald-100 hover:border-emerald-300 flex flex-col h-full hover:-translate-y-2">
    <!-- Clickable overlay to view service details -->
    <a href="{{ route('services.show', $service) }}" class="absolute inset-0 z-0" aria-label="View {{ $service->name }}"></a>

    @php 
        // 1. Fallback product image for Honey (ID 1) or Tonic (ID 2)
        $fallbackImage = ($service->id == 2 || str_contains(strtolower($service->name ?? ''), 'tonic')) 
            ? asset('uploads/products/habibi-tonic.png') 
            : asset('uploads/products/habibi-honey.png');

        // Default to asset($service->image) with fallback
        if (!empty($service->image)) {
            $productImage = asset(ltrim($service->image, '/'));
        } else {
            $productImage = $fallbackImage;
        }

        // 2. Pricing: Rs. 1,200 bold with Rs. 1,500 struck through as original price
        $displaySalePrice = !empty($service->sale_price) ? number_format($service->sale_price) : '1,200';
        $displayOriginalPrice = !empty($service->price) ? number_format($service->price) : '1,500';
    @endphp

    <!-- Product Image Container -->
    <div class="relative h-64 overflow-hidden bg-gradient-to-b from-emerald-50/60 via-amber-50/30 to-white flex items-center justify-center p-4">
        <img src="{{ $productImage }}" 
             alt="{{ $service->name }}" 
             onerror="this.onerror=null; this.src='{{ $fallbackImage }}';"
             class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-700 ease-out drop-shadow-sm">
        
        <!-- Glassmorphic Overlay on Hover -->
        <div class="absolute inset-0 bg-emerald-950/30 opacity-0 group-hover:opacity-100 transition-all duration-500 backdrop-blur-[2px] flex items-center justify-center pointer-events-none">
            <span class="px-5 py-2.5 bg-white/95 text-emerald-800 rounded-xl font-bold uppercase tracking-wider text-[11px] shadow-xl border border-emerald-100 transform translate-y-3 group-hover:translate-y-0 duration-300">
                View Product Details
            </span>
        </div>

        <!-- Top Badges -->
        <div class="absolute top-4 inset-x-4 flex justify-between items-start z-10 pointer-events-none">
            <div class="flex flex-col gap-1.5">
                @if($service->category)
                    <span class="bg-emerald-800/90 text-white backdrop-blur-md px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider shadow-sm flex items-center gap-1.5 w-fit">
                        <i class="fa-solid fa-leaf text-amber-400 text-[9px]"></i>
                        {{ $service->category->name }}
                    </span>
                @else
                    <span class="bg-emerald-800/90 text-white backdrop-blur-md px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider shadow-sm flex items-center gap-1.5 w-fit">
                        <i class="fa-solid fa-leaf text-amber-400 text-[9px]"></i>
                        Habibi Herbal
                    </span>
                @endif
                <span class="bg-amber-500 text-emerald-950 px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm flex items-center gap-1 w-fit">
                    <i class="fa-solid fa-certificate text-[9px]"></i> 100% Pure
                </span>
            </div>

            <!-- Heart / Favorite Button -->
            <div x-data="{ 
                isFavorited: {{ Auth::check() && $service->isFavoritedBy(Auth::user()) ? 'true' : 'false' }}, 
                loading: false,
                toggle() {
                    @if(Auth::check())
                        if(this.loading) return;
                        this.loading = true;
                        fetch('{{ route('services.favorite', $service) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.isFavorited = data.favorited;
                            this.loading = false;
                        })
                        .catch(() => this.loading = false);
                    @else
                        window.location.href = '{{ route('login') }}';
                    @endif
                }
            }" class="pointer-events-auto relative z-20">
                <button @click.prevent="toggle()" 
                        class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm text-sm"
                        :class="isFavorited ? 'bg-amber-500 text-white shadow-amber-500/30' : 'bg-white/95 backdrop-blur-sm text-slate-400 hover:text-amber-500 hover:bg-white'"
                        title="Add to wishlist">
                    <i class="fa-solid fa-heart" :class="{'animate-ping': loading}"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Card Content Body -->
    <div class="p-5 flex-1 flex flex-col justify-between bg-gradient-to-b from-white to-emerald-50/20 relative">
        <div class="space-y-2.5">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-seedling text-amber-500 text-[10px]"></i>
                    {{ $service->brand ?? 'Habibi Herbal' }}
                </span>
                <div class="flex items-center gap-1 text-amber-400 text-xs">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <span class="text-[11px] font-bold text-slate-600 ml-1">5.0</span>
                </div>
            </div>

            <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-emerald-700 transition-colors">
                <a href="{{ route('services.show', $service) }}" class="relative z-10 hover:underline">
                    {{ $service->name }}
                </a>
            </h3>

            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                {{ $service->short_description ?? ($service->description ? Str::limit(strip_tags($service->description), 90) : 'Pure traditional herbal remedy crafted with authentic ingredients for natural health and vitality.') }}
            </p>
        </div>

        <!-- Pricing & Action Hub -->
        <div class="pt-4 mt-3 border-t border-emerald-100 flex items-center justify-between gap-2 flex-wrap sm:flex-nowrap pointer-events-auto relative z-10">
            <!-- Price Display: Struck-through original price (Rs. 1,500) above current price (Rs. 1,200) -->
            <div class="flex flex-col">
                <div class="flex items-center gap-1.5 mb-0.5">
                    <span class="text-xs font-bold text-slate-400 line-through">
                        Rs. {{ $displayOriginalPrice }}
                    </span>
                    <span class="text-[9px] font-black uppercase text-amber-700 bg-amber-500/15 border border-amber-300/40 px-1.5 py-0.5 rounded">
                        20% OFF
                    </span>
                </div>
                <div class="text-2xl font-black text-emerald-800 tracking-tight leading-none">
                    Rs. {{ $displaySalePrice }}
                </div>
            </div>

            <!-- Action Buttons: Cart Button and High-Visibility Rounded Buy Now Button right next to price -->
            <div class="flex items-center gap-2 shrink-0">
                <!-- Add to Cart Button -->
                <a href="{{ route('cart.add', $service->id) }}" 
                   class="w-10 h-10 rounded-full border-2 border-emerald-700 text-emerald-800 bg-white hover:bg-emerald-700 hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105 active:scale-95 group/cart"
                   title="Add to Cart"
                   aria-label="Add to Cart">
                    <i class="fa-solid fa-cart-shopping text-xs text-emerald-700 group-hover/cart:text-white transition-colors"></i>
                </a>

                <!-- High-Visibility Rounded 'Buy Now' Button -->
                <a href="{{ route('cart.buyNow', $service->id) }}" 
                   class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-full bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 hover:from-amber-600 hover:via-amber-500 hover:to-amber-600 text-slate-950 font-black text-xs uppercase tracking-wider transition-all duration-200 shadow-lg shadow-amber-500/35 hover:shadow-amber-500/50 hover:scale-105 active:scale-95 border border-amber-300 group/buy whitespace-nowrap">
                    <i class="fa-solid fa-bolt text-slate-950 text-xs group-hover/buy:scale-110 transition-transform"></i>
                    <span>Buy Now</span>
                </a>
            </div>
        </div>
    </div>
</div>
