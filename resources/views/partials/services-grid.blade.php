@php
    $hasPakistan = isset($pakistanServices) && $pakistanServices->count() > 0;
    $hasGlobal = isset($globalServices) && $globalServices->count() > 0;
    $hasDirectServices = isset($services) && $services->count() > 0;
@endphp

@if($hasDirectServices)
    <!-- Direct Grid Display (e.g. Favorites, Category Pages, or Filtered Lists) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 py-8">
        @foreach($services as $service)
            <div class="h-full">
                @include('partials.services-grid-item', ['service' => $service])
            </div>
        @endforeach
    </div>

@elseif($hasPakistan || $hasGlobal)
    <!-- Habibi Herbal Featured Collection (Pakistan) -->
    @if($hasPakistan)
    <div class="mb-24 py-8 relative group/pak">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 px-2">
            <div class="text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                    <span class="px-4 py-1.5 bg-emerald-700/10 text-emerald-800 rounded-full text-[10px] font-black uppercase tracking-[0.25em] border border-emerald-700/20 flex items-center gap-1.5">
                        <i class="fa-solid fa-leaf text-amber-500 text-[10px]"></i> 100% Pure & Organic
                    </span>
                    <div class="h-[1px] w-12 bg-emerald-700/20 hidden md:block"></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $pakistanServices->count() }} Products Available</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-emerald-950 tracking-tight leading-tight">
                    Habibi Herbal <span class="text-emerald-700">Creations</span>
                </h2>
            </div>
            
            <div class="flex gap-3">
                <button type="button" aria-label="Previous Slide" class="pakistan-prev w-12 h-12 rounded-2xl bg-white shadow-md shadow-emerald-950/5 flex items-center justify-center text-emerald-900 hover:bg-emerald-700 hover:text-white transition-all border border-emerald-100 cursor-pointer active:scale-95 group/btn">
                    <i class="fa-solid fa-arrow-left-long text-base group-hover/btn:-translate-x-1 transition-transform"></i>
                </button>
                <button type="button" aria-label="Next Slide" class="pakistan-next w-12 h-12 rounded-2xl bg-white shadow-md shadow-emerald-950/5 flex items-center justify-center text-emerald-900 hover:bg-emerald-700 hover:text-white transition-all border border-emerald-100 cursor-pointer active:scale-95 group/btn">
                    <i class="fa-solid fa-arrow-right-long text-base group-hover/btn:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>

        <div class="swiper pakistan-services-swiper overflow-hidden px-2 pb-6">
            <div class="swiper-wrapper py-6">
                @foreach($pakistanServices as $service)
                    <div class="swiper-slide h-auto">
                        @include('partials.services-grid-item', ['service' => $service])
                    </div>
                @endforeach
            </div>
            <div class="pakistan-pagination flex justify-center mt-8"></div>
        </div>
    </div>
    @endif

    <!-- Global Herbal Selection -->
    @if($hasGlobal)
    <div class="mb-24 py-8 relative group/glob">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 px-2">
            <div class="text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                    <span class="px-4 py-1.5 bg-amber-500/10 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-[0.25em] border border-amber-500/20 flex items-center gap-1.5">
                        <i class="fa-solid fa-earth-americas text-amber-500 text-[10px]"></i> Global Selection
                    </span>
                    <div class="h-[1px] w-12 bg-amber-500/20 hidden md:block"></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $globalServices->count() }} Worldwide Items</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-emerald-950 tracking-tight leading-tight">
                    Global <span class="text-amber-600">Herbal Remedies</span>
                </h2>
            </div>
            
            <div class="flex gap-3">
                <button type="button" aria-label="Previous Slide" class="global-prev w-12 h-12 rounded-2xl bg-white shadow-md shadow-emerald-950/5 flex items-center justify-center text-emerald-900 hover:bg-emerald-700 hover:text-white transition-all border border-emerald-100 cursor-pointer active:scale-95 group/btn">
                    <i class="fa-solid fa-arrow-left-long text-base group-hover/btn:-translate-x-1 transition-transform"></i>
                </button>
                <button type="button" aria-label="Next Slide" class="global-next w-12 h-12 rounded-2xl bg-white shadow-md shadow-emerald-950/5 flex items-center justify-center text-emerald-900 hover:bg-emerald-700 hover:text-white transition-all border border-emerald-100 cursor-pointer active:scale-95 group/btn">
                    <i class="fa-solid fa-arrow-right-long text-base group-hover/btn:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>

        <div class="swiper global-services-swiper overflow-hidden px-2 pb-6">
            <div class="swiper-wrapper py-6">
                @foreach($globalServices as $service)
                    <div class="swiper-slide h-auto">
                        @include('partials.services-grid-item', ['service' => $service])
                    </div>
                @endforeach
            </div>
            <div class="global-pagination flex justify-center mt-8"></div>
        </div>
    </div>
    @endif

@else
    <!-- Empty State -->
    <div class="text-center py-24 px-6 bg-white rounded-3xl border border-emerald-100 shadow-xl max-w-2xl mx-auto my-12">
        <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-emerald-100 text-emerald-700 shadow-inner">
            <i class="fa-solid fa-leaf text-amber-500 text-3xl"></i>
        </div>
        <h3 class="text-2xl font-black text-emerald-950 tracking-tight">No Herbal Products Found</h3>
        <p class="text-slate-500 mt-3 font-medium max-w-md mx-auto text-sm leading-relaxed">
            We are currently updating our natural herbal inventory. Discover our pure natural honey and herbal tonics or consult our specialist herbalists.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-md shadow-emerald-700/20 active:scale-95">
                <i class="fa-solid fa-comments text-amber-300"></i>
                <span>Consult Our Herbalists</span>
            </a>
            <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-xl font-bold text-xs uppercase tracking-wider transition-all active:scale-95">
                <i class="fa-solid fa-rotate-left"></i>
                <span>View All Products</span>
            </a>
        </div>
    </div>
@endif
