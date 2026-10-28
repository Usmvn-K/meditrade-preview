@extends('layouts.public')

@section('title', $service->name . ' - Gohar Mart')
@section('description', Str::limit($service->description, 160))

@push('styles')
<style>
    .product-bg { background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #fefce8 100%); }
    .zoom-container { overflow: hidden; }
    .zoom-container img { transition: transform 0.7s cubic-bezier(.23,1,.32,1); }
    .zoom-container:hover img { transform: scale(1.08); }
    .thumb-active { border-color: #15803d !important; box-shadow: 0 0 0 3px rgba(21,128,61,0.2); }
    .badge-pulse { animation: badgePulse 2s ease-in-out infinite; }
    @keyframes badgePulse { 0%,100%{opacity:1;} 50%{opacity:0.7;} }
    .price-glow { text-shadow: 0 4px 20px rgba(21,128,61,0.2); }
    .btn-primary { background: linear-gradient(135deg, #052e16, #15803d); transition: all 0.3s ease; }
    .btn-primary:hover { background: linear-gradient(135deg, #15803d, #16a34a); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(21,128,61,0.35); }
    .btn-secondary { background: white; border: 2px solid #e2e8f0; transition: all 0.3s ease; }
    .btn-secondary:hover { border-color: #15803d; color: #15803d; transform: translateY(-1px); }
    .spec-card { transition: all 0.3s ease; }
    .spec-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .tab-btn.active { background: #052e16; color: white; }
    .section-fade { opacity: 0; transform: translateY(20px); animation: fadeUp 0.6s ease forwards; }
    @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
</style>
@endpush

@section('content')
<div class="product-bg min-h-screen pt-28 pb-20">
    <div class="max-w-[1300px] mx-auto px-4 sm:px-6">

        {{-- Breadcrumbs --}}
        <nav class="flex mb-8 text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-green-700 transition-colors">Home</a>
            <span class="mx-3 opacity-30">/</span>
            <a href="{{ route('services') }}" class="hover:text-green-700 transition-colors">Store</a>
            @if($service->category)
                <span class="mx-3 opacity-30">/</span>
                <span class="text-green-700">{{ $service->category->name }}</span>
            @endif
        </nav>

        {{-- Main Product Grid --}}
        <div class="grid lg:grid-cols-12 gap-10 items-start" x-data="{
            mainImage: '{{ $service->getFeaturedImageUrl() }}',
            basePrice: {{ $service->is_on_sale && $service->sale_price ? $service->sale_price : ($service->price ?? 0) }},
            qty: 1,
            selectedAddons: [],
            activeTab: 'description',
            totalPrice() {
                let total = this.basePrice * this.qty;
                this.selectedAddons.forEach(a => total += parseInt(a.price));
                return total;
            }
        }">

            {{-- ===== LEFT: Image Gallery ===== --}}
            <div class="lg:col-span-6 section-fade" style="animation-delay:0.1s">
                {{-- Main Image --}}
                <div class="zoom-container rounded-[2.5rem] overflow-hidden border-4 border-white shadow-2xl shadow-green-900/10 mb-4 relative" style="height:460px;">
                    <img :src="mainImage" class="w-full h-full object-cover" alt="{{ $service->name }}">
                    @if($service->is_on_sale && $service->sale_price)
                    <div class="absolute top-6 left-6 z-10">
                        <span class="bg-red-500 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg badge-pulse">
                            {{ number_format((($service->price - $service->sale_price) / $service->price) * 100) }}% OFF
                        </span>
                    </div>
                    @endif
                    @if($service->is_featured)
                    <div class="absolute top-6 right-6 z-10">
                        <span class="bg-amber-500 text-white px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg flex items-center gap-1">
                            <i class="fa-solid fa-fire"></i> Featured
                        </span>
                    </div>
                    @endif
                </div>

                {{-- Thumbnail Strip --}}
                @php $allImgUrls = $service->getAllImageUrls(); @endphp
                @if(count($allImgUrls) > 1)
                <div class="flex gap-3 overflow-x-auto pb-2">
                    @foreach($allImgUrls as $i => $imgUrl)
                    <button @click="mainImage = '{{ $imgUrl }}'"
                            class="w-20 h-20 rounded-2xl overflow-hidden border-2 flex-shrink-0 transition-all {{ $i === 0 ? 'thumb-active border-green-700' : 'border-transparent' }}"
                            :class="mainImage === '{{ $imgUrl }}' ? 'thumb-active' : 'border-transparent hover:border-green-300'">
                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="thumb">
                    </button>
                    @endforeach
                </div>
                @endif

                {{-- Trust Signals --}}
                <div class="mt-6 grid grid-cols-3 gap-3">
                    @foreach([
                        ['fa-shield-halved','100% Pure','Certified Quality'],
                        ['fa-truck-fast','Free Delivery','On All Orders'],
                        ['fa-rotate-left','Easy Returns','7 Day Policy'],
                    ] as [$icon, $title, $sub])
                    <div class="bg-white rounded-2xl p-4 text-center border border-slate-100 shadow-sm">
                        <i class="fa-solid {{ $icon }} text-green-700 text-lg mb-2 block"></i>
                        <div class="text-[9px] font-black text-slate-800 uppercase tracking-wider">{{ $title }}</div>
                        <div class="text-[8px] text-slate-400 font-bold">{{ $sub }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ===== RIGHT: Product Info + Buy Panel ===== --}}
            <div class="lg:col-span-6 space-y-6 section-fade" style="animation-delay:0.2s">

                {{-- Badges --}}
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-[9px] font-black uppercase tracking-widest rounded-full border border-green-200">Verified Quality</span>
                    @if($service->brand)
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 text-[9px] font-black uppercase tracking-widest rounded-full">{{ $service->brand }}</span>
                    @endif
                    @if($service->is_best_seller)
                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-[9px] font-black uppercase tracking-widest rounded-full border border-amber-200">🔥 Best Seller</span>
                    @endif
                    @if($service->is_new_arrival)
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-[9px] font-black uppercase tracking-widest rounded-full border border-purple-200">✨ New Arrival</span>
                    @endif
                </div>

                {{-- Name --}}
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-[#052e16] tracking-tight leading-tight uppercase mb-3">
                        {{ $service->name }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-4 text-sm">
                        <div class="flex items-center gap-1">
                            @for($i=0; $i<5; $i++)
                            <i class="fa-solid fa-star text-amber-400 text-xs {{ $i < floor($service->averageRating()) ? '' : 'opacity-30' }}"></i>
                            @endfor
                            <span class="font-black text-slate-700 ml-1">{{ number_format($service->averageRating(), 1) }}</span>
                            <span class="text-slate-400 text-xs">({{ $service->reviewCount() }} reviews)</span>
                        </div>
                        @if($service->location)
                        <div class="flex items-center gap-1 text-slate-500">
                            <i class="fa-solid fa-location-dot text-green-700 text-xs"></i>
                            <span class="text-xs font-bold">{{ $service->location }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Price --}}
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm">
                    <div class="flex items-end gap-4 mb-2">
                        <div>
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-widest block mb-1">Price</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-black text-green-800">PKR</span>
                                <span class="text-5xl font-black text-[#052e16] tracking-tighter price-glow"
                                      x-text="new Intl.NumberFormat().format(totalPrice())"></span>
                            </div>
                        </div>
                        @if($service->is_on_sale && $service->sale_price)
                        <div class="flex flex-col items-start mb-1">
                            <span class="text-sm text-slate-400 line-through font-bold">PKR {{ number_format($service->price) }}</span>
                            <span class="text-xs font-black text-red-600 bg-red-50 px-2 py-0.5 rounded-full border border-red-100 mt-1">
                                Save PKR {{ number_format($service->price - $service->sale_price) }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Tax inclusive · Free delivery</p>
                </div>

                {{-- Short Description --}}
                @if($service->short_description)
                <div class="bg-green-50 border-l-4 border-green-700 rounded-r-2xl px-5 py-4">
                    <p class="text-sm font-medium text-green-900 leading-relaxed">{{ $service->short_description }}</p>
                </div>
                @endif

                {{-- Add-ons --}}
                @if(!empty($service->add_ons))
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black text-green-800 uppercase tracking-[0.3em] mb-4">⚡ Optional Add-Ons</p>
                    <div class="space-y-3">
                        @foreach($service->add_ons as $addon)
                        <label class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl cursor-pointer hover:border-green-300 hover:bg-green-50/50 transition-all group"
                               x-data="{active:false}" @click="active=!active; if(active) selectedAddons.push({name:'{{ addslashes($addon['name']) }}',price:{{$addon['price']}}}); else selectedAddons=selectedAddons.filter(a=>a.name!=='{{ addslashes($addon['name']) }}')">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-lg border-2 flex items-center justify-center transition-all text-xs"
                                     :class="active ? 'bg-green-700 border-green-700 text-white' : 'border-slate-300 text-transparent'">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-800">{{ $addon['name'] }}</span>
                            </div>
                            <span class="text-sm font-black text-green-700">+PKR {{ number_format($addon['price']) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Quantity + Buttons --}}
                <div class="space-y-4">
                    {{-- Qty Picker --}}
                    <div class="flex items-center gap-4">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Quantity</span>
                        <div class="flex items-center bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                            <button @click="qty = Math.max(1, qty-1)" class="w-10 h-10 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-colors font-black text-lg">−</button>
                            <span x-text="qty" class="w-10 text-center font-black text-slate-800"></span>
                            <button @click="qty++" class="w-10 h-10 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-colors font-black text-lg">+</button>
                        </div>
                    </div>

                        <button type="button" 
                                @click="window.addToCartAjax ? window.addToCartAjax({{ $service->id }}, qty) : window.location.href='{{ route('cart.add', $service) }}'" 
                                class="flex-1 btn-primary text-white py-4 rounded-[1.5rem] font-black text-[11px] uppercase tracking-[0.25em] flex items-center justify-center gap-3 shadow-lg shadow-green-900/20 cursor-pointer">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                        <a href="{{ route('cart.buyNow', $service) }}" class="flex-1 btn-secondary text-slate-800 py-4 rounded-[1.5rem] font-black text-[11px] uppercase tracking-[0.25em] flex items-center justify-center gap-3">
                            <i class="fa-solid fa-bolt text-amber-500"></i> Buy Now
                        </a>
                    </div>
                </div>

                {{-- Specs Grid --}}
                @php
                    $specs = [];
                    if($service->category) $specs[] = ['fa-list','Category',$service->category->name];
                    if($service->sub_category) $specs[] = ['fa-sitemap','Type',$service->sub_category];
                    if($service->brand) $specs[] = ['fa-tag','Brand',$service->brand];
                    if($service->unit) $specs[] = ['fa-scale-balanced','Unit',$service->unit];
                    $specs[] = ['fa-box','Condition','Brand New'];
                    $specs[] = ['fa-shield-check','Warranty','Guaranteed'];
                @endphp
                @if(count($specs))
                <div class="grid grid-cols-3 gap-3">
                    @foreach($specs as [$icon,$label,$val])
                    <div class="spec-card bg-white rounded-2xl p-4 border border-slate-100 text-center shadow-sm cursor-default">
                        <i class="fa-solid {{ $icon }} text-green-700 text-base mb-2 block"></i>
                        <div class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ $label }}</div>
                        <div class="text-[10px] font-black text-slate-800 uppercase leading-tight">{{ $val }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- ===== TABS: Description, Packages, Reviews ===== --}}
        <div class="mt-16 section-fade" style="animation-delay:0.3s" x-data="{tab:'description'}">
            <div class="flex gap-2 mb-8 bg-white rounded-[2rem] p-2 border border-slate-100 shadow-sm w-fit">
                <button @click="tab='description'" :class="tab==='description' ? 'bg-[#052e16] text-white' : 'text-slate-500 hover:text-slate-800'"
                        class="px-6 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all">
                    📋 Description
                </button>
                @if(!empty($service->packages))
                <button @click="tab='packages'" :class="tab==='packages' ? 'bg-[#052e16] text-white' : 'text-slate-500 hover:text-slate-800'"
                        class="px-6 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all">
                    📦 Packages
                </button>
                @endif
                <button @click="tab='reviews'" :class="tab==='reviews' ? 'bg-[#052e16] text-white' : 'text-slate-500 hover:text-slate-800'"
                        class="px-6 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all">
                    ⭐ Reviews ({{ $service->reviewCount() }})
                </button>
            </div>

            {{-- Description Tab --}}
            <div x-show="tab==='description'" x-transition class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm">
                <h3 class="text-2xl font-black text-[#052e16] uppercase tracking-tight mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-green-700 text-white flex items-center justify-center">
                        <i class="fa-solid fa-info text-sm"></i>
                    </div>
                    Product Details
                </h3>
                <div class="text-slate-600 text-base leading-loose max-w-3xl">
                    {!! nl2br(e($service->description)) !!}
                </div>
            </div>

            {{-- Packages Tab --}}
            @if(!empty($service->packages))
            <div x-show="tab==='packages'" x-transition class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($service->packages as $pkg)
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 group">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-[9px] font-black uppercase tracking-widest rounded-full">Package</span>
                        <div class="text-right">
                            <span class="text-[10px] text-slate-400 font-bold">PKR</span>
                            <div class="text-2xl font-black text-[#052e16]">{{ number_format($pkg['price']) }}</div>
                        </div>
                    </div>
                    <h4 class="text-lg font-black text-[#052e16] uppercase mb-2 tracking-tight">{{ $pkg['name'] }}</h4>
                    <p class="text-sm text-slate-500 leading-relaxed mb-6">{{ $pkg['description'] ?? 'Premium package option.' }}</p>
                    <a href="{{ route('cart.add', $service) }}" class="w-full py-4 bg-slate-50 group-hover:bg-[#052e16] group-hover:text-white text-[#052e16] rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 transition-all">
                        Select <i class="fa-solid fa-arrow-right text-[8px]"></i>
                    </a>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Reviews Tab --}}
            <div x-show="tab==='reviews'" x-transition>
                @if($service->reviews()->count() > 0)
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($service->reviews()->with('user')->latest()->take(6)->get() as $review)
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-800 flex items-center justify-center font-black text-lg">
                                {{ substr($review->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <div class="font-black text-sm text-slate-800">{{ $review->user->name ?? 'Customer' }}</div>
                                <div class="flex gap-0.5 mt-1">
                                    @for($s=0;$s<5;$s++)
                                    <i class="fa-solid fa-star text-[10px] {{ $s < $review->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <span class="ml-auto text-[9px] text-slate-400 font-bold">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $review->review }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-[2.5rem] p-16 text-center border border-slate-100 shadow-sm">
                    <i class="fa-solid fa-star text-slate-200 text-5xl mb-4 block"></i>
                    <p class="text-slate-400 font-bold">No reviews yet. Be the first to review!</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedServices->count() > 0)
        <div class="mt-20 section-fade" style="animation-delay:0.4s">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-black text-[#052e16] uppercase tracking-tight">You May Also Like</h2>
                <a href="{{ route('services') }}" class="text-[10px] font-black text-green-700 uppercase tracking-[0.3em] hover:text-green-900 transition-colors flex items-center gap-2">
                    View All <i class="fa-solid fa-arrow-right text-[8px]"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedServices as $rel)
                <a href="{{ route('services.show', $rel) }}" class="group bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <div class="h-48 overflow-hidden zoom-container">
                        <img src="{{ $rel->getFeaturedImageUrl() }}" class="w-full h-full object-cover" alt="{{ $rel->name }}">
                    </div>
                    <div class="p-6">
                        <p class="text-[8px] font-black text-green-700 uppercase tracking-[0.3em] mb-2">{{ $rel->category->name ?? 'Herbal' }}</p>
                        <h4 class="text-sm font-black text-[#052e16] uppercase mb-4 line-clamp-2 leading-tight group-hover:text-green-800 transition-colors">{{ $rel->name }}</h4>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-50">
                            <div>
                                <span class="text-[8px] font-black text-slate-400 uppercase">PKR</span>
                                <span class="text-lg font-black text-[#052e16] block leading-none">{{ number_format($rel->is_on_sale && $rel->sale_price ? $rel->sale_price : $rel->price) }}</span>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-green-700 text-white flex items-center justify-center text-xs group-hover:bg-green-600 transition-colors">
                                <i class="fa-solid fa-cart-plus"></i>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
