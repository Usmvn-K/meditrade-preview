<x-app-layout>

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

    .cart-page { background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 40%, #fff7ed 100%); min-height: 100vh; font-family: 'Inter', sans-serif; }

    /* Cart Item Card */
    .cart-item-card { background: white; border: 1.5px solid #f1f5f9; border-radius: 2rem; transition: all 0.3s ease; overflow: hidden; }
    .cart-item-card:hover { border-color: #bbf7d0; box-shadow: 0 12px 40px rgba(21,128,61,0.08); transform: translateY(-2px); }

    /* Image Box */
    .cart-img-box { width: 96px; height: 96px; border-radius: 1.25rem; overflow: hidden; background: #f8fafc; flex-shrink: 0; border: 2px solid #f1f5f9; }
    .cart-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
    .cart-item-card:hover .cart-img-box img { transform: scale(1.08); }

    /* Qty Controls */
    .qty-btn { width: 36px; height: 36px; border: 1.5px solid #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 14px; background: #f8fafc; cursor: pointer; transition: all 0.2s; }
    .qty-btn:hover { background: #052e16; color: white; border-color: #052e16; }
    .qty-display { width: 40px; text-align: center; font-weight: 900; font-size: 15px; color: #0f172a; }

    /* Remove Button */
    .remove-btn { width: 38px; height: 38px; border-radius: 12px; background: #fff1f2; border: 1.5px solid #fecdd3; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; color: #e11d48; }
    .remove-btn:hover { background: #e11d48; color: white; border-color: #e11d48; transform: scale(1.1); }

    /* Summary Card */
    .summary-card { background: white; border: 1.5px solid #e2e8f0; border-radius: 2rem; position: sticky; top: 100px; overflow: hidden; }
    .summary-header { background: linear-gradient(135deg, #052e16, #15803d); padding: 28px 28px 24px; }

    /* Checkout Button */
    .checkout-btn { background: linear-gradient(135deg, #052e16, #16a34a); border-radius: 1.25rem; padding: 18px; display: flex; align-items: center; justify-content: center; gap: 10px; font-weight: 900; font-size: 12px; text-transform: uppercase; letter-spacing: 0.2em; color: white; transition: all 0.3s ease; width: 100%; border: none; cursor: pointer; }
    .checkout-btn:hover { background: linear-gradient(135deg, #16a34a, #22c55e); transform: translateY(-2px); box-shadow: 0 14px 40px rgba(21,128,61,0.35); }

    /* Continue Shopping */
    .continue-btn { border: 2px solid #e2e8f0; border-radius: 1.25rem; padding: 14px; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 900; font-size: 11px; text-transform: uppercase; letter-spacing: 0.2em; color: #475569; background: white; transition: all 0.25s; width: 100%; }
    .continue-btn:hover { border-color: #052e16; color: #052e16; background: #f0fdf4; }

    /* Trust Badges */
    .trust-badge { display: flex; align-items: center; gap: 12px; padding: 14px 18px; background: #f8fafc; border-radius: 14px; border: 1px solid #f1f5f9; }

    /* Empty Cart */
    .empty-cart { background: white; border-radius: 2.5rem; padding: 80px 40px; text-align: center; border: 1.5px solid #f1f5f9; }
    .empty-icon-ring { width: 120px; height: 120px; background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; border: 2px dashed #bbf7d0; }

    /* Progress Bar */
    .progress-bar-outer { height: 6px; background: #f1f5f9; border-radius: 99px; overflow: hidden; }
    .progress-bar-inner { height: 100%; background: linear-gradient(90deg, #15803d, #22c55e); border-radius: 99px; transition: width 0.5s ease; }

    /* Sale Badge */
    .sale-chip { background: linear-gradient(135deg, #ef4444, #f97316); color: white; font-size: 8px; font-weight: 900; letter-spacing: 0.15em; padding: 2px 8px; border-radius: 99px; text-transform: uppercase; display: inline-block; }

    /* Fade in animation */
    .fade-in { animation: fadeIn 0.5s ease both; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .fade-in-1 { animation-delay: 0.05s; }
    .fade-in-2 { animation-delay: 0.1s; }
    .fade-in-3 { animation-delay: 0.15s; }
</style>
@endpush

<div class="cart-page py-10 px-4 sm:px-6 lg:px-8 pt-28">
    <div class="max-w-[1220px] mx-auto">

        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-10 fade-in">
            <div>
                <p class="text-[10px] font-black text-green-700 uppercase tracking-[0.35em] mb-1.5 flex items-center gap-2">
                    <i class="fa-solid fa-leaf"></i> Gohar Mart
                </p>
                <h1 class="text-4xl font-black text-[#052e16] uppercase tracking-tight leading-none">
                    Your Cart
                </h1>
                @if(count($cart) > 0)
                <p class="text-sm text-slate-400 font-bold mt-2">{{ count($cart) }} {{ Str::plural('item', count($cart)) }} in your cart</p>
                @endif
            </div>
            <a href="{{ route('services') }}" class="hidden sm:flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-green-700 transition-colors">
                <i class="fa-solid fa-arrow-left text-[8px]"></i> Continue Shopping
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-6 px-6 py-4 rounded-2xl bg-green-50 border border-green-200 flex items-center gap-4 fade-in">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-circle-check text-green-600"></i>
            </div>
            <p class="text-green-800 font-bold text-sm">{{ session('success') }}</p>
        </div>
        @endif

        @if(count($cart) > 0)

        {{-- Free Delivery Progress --}}
        @php
            $cartTotal = collect($cart)->sum(fn($d) => $d['price'] * $d['quantity']);
            $freeDeliveryThreshold = 3000;
            $progressPct = min(100, ($cartTotal / $freeDeliveryThreshold) * 100);
            $remaining = max(0, $freeDeliveryThreshold - $cartTotal);
        @endphp
        <div class="bg-white rounded-2xl px-6 py-4 border border-slate-100 mb-8 flex items-center gap-5 fade-in fade-in-1">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $progressPct >= 100 ? 'bg-green-100' : 'bg-amber-50' }}">
                <i class="fa-solid fa-truck-fast {{ $progressPct >= 100 ? 'text-green-600' : 'text-amber-500' }}"></i>
            </div>
            <div class="flex-1">
                @if($progressPct >= 100)
                    <p class="text-xs font-black text-green-700 mb-1.5">🎉 You unlocked FREE delivery!</p>
                @else
                    <p class="text-xs font-bold text-slate-600 mb-1.5">Add <span class="font-black text-green-700">Rs. {{ number_format($remaining) }}</span> more for <span class="font-black text-green-700">FREE delivery</span></p>
                @endif
                <div class="progress-bar-outer">
                    <div class="progress-bar-inner" style="width: {{ $progressPct }}%"></div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">

            {{-- ===== LEFT: Cart Items ===== --}}
            <div class="lg:col-span-7 space-y-4">

                {{-- Column Labels --}}
                <div class="hidden md:grid grid-cols-12 gap-4 px-6 mb-2">
                    <div class="col-span-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.25em]">Product</div>
                    <div class="col-span-2 text-[9px] font-black text-slate-400 uppercase tracking-[0.25em] text-center">Price</div>
                    <div class="col-span-3 text-[9px] font-black text-slate-400 uppercase tracking-[0.25em] text-center">Quantity</div>
                    <div class="col-span-1 text-[9px] font-black text-slate-400 uppercase tracking-[0.25em] text-right"></div>
                </div>

                @foreach($cart as $id => $details)
                @php
                    $lineTotal = $details['price'] * $details['quantity'];
                    $savings = !empty($details['is_on_sale']) ? ($details['original_price'] - $details['price']) * $details['quantity'] : 0;
                @endphp
                <div class="cart-item-card p-5 fade-in" style="animation-delay: {{ $loop->index * 0.07 + 0.15 }}s" data-id="{{ $id }}">
                    <div class="flex items-center gap-4">

                        {{-- Product Image --}}
                        <div class="cart-img-box">
                            <img src="{{ $details['image'] ?? '' }}"
                                 alt="{{ $details['name'] }}"
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><i class=\'fa-solid fa-leaf text-green-300 text-2xl\'></i></div>'">
                        </div>

                        {{-- Product Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-start justify-between gap-2 mb-1">
                                <div class="min-w-0">
                                    <p class="text-[9px] font-black text-green-700 uppercase tracking-[0.25em] mb-0.5">Gohar Mart</p>
                                    <h4 class="text-sm font-black text-[#052e16] uppercase leading-tight truncate max-w-[220px]">{{ $details['name'] }}</h4>
                                </div>
                                {{-- Remove (Mobile) --}}
                                <button class="remove-from-cart md:hidden">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                            </div>

                            {{-- Price (Mobile) --}}
                            <div class="flex items-center gap-2 mt-1 md:hidden">
                                @if(!empty($details['is_on_sale']))
                                    <span class="text-[10px] text-slate-400 line-through">Rs.{{ number_format($details['original_price']) }}</span>
                                    <span class="text-sm font-black text-red-600">Rs.{{ number_format($details['price']) }}</span>
                                    <span class="sale-chip">Sale</span>
                                @else
                                    <span class="text-sm font-black text-[#052e16]">Rs.{{ number_format($details['price']) }}</span>
                                @endif
                            </div>

                            {{-- Desktop Row --}}
                            <div class="hidden md:flex items-center gap-6 mt-3">
                                {{-- Unit Price --}}
                                <div class="w-20 flex-shrink-0">
                                    @if(!empty($details['is_on_sale']))
                                        <span class="text-[10px] text-slate-400 line-through block">Rs.{{ number_format($details['original_price']) }}</span>
                                        <span class="text-sm font-black text-red-600">Rs.{{ number_format($details['price']) }}</span>
                                        <span class="sale-chip mt-1">Sale</span>
                                    @else
                                        <span class="text-sm font-black text-[#052e16]">Rs.{{ number_format($details['price']) }}</span>
                                    @endif
                                </div>

                                {{-- Qty Controls --}}
                                <div class="flex items-center gap-2">
                                    <button class="qty-btn qty-minus">−</button>
                                    <span class="qty-display">{{ $details['quantity'] }}</span>
                                    <input type="hidden" class="quantity update-cart" value="{{ $details['quantity'] }}">
                                    <button class="qty-btn qty-plus">+</button>
                                </div>

                                {{-- Line Total --}}
                                <div class="ml-auto text-right">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase block">Total</span>
                                    <span class="text-base font-black text-[#052e16]">Rs.{{ number_format($lineTotal) }}</span>
                                    @if($savings > 0)
                                    <span class="text-[9px] text-green-600 font-black block">Save Rs.{{ number_format($savings) }}</span>
                                    @endif
                                </div>

                                {{-- Remove --}}
                                <button class="remove-from-cart ml-2">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>

                            {{-- Mobile: Qty + Total Row --}}
                            <div class="flex items-center justify-between mt-3 md:hidden">
                                <div class="flex items-center gap-2">
                                    <button class="qty-btn qty-minus">−</button>
                                    <span class="qty-display">{{ $details['quantity'] }}</span>
                                    <input type="hidden" class="quantity update-cart" value="{{ $details['quantity'] }}">
                                    <button class="qty-btn qty-plus">+</button>
                                </div>
                                <span class="text-base font-black text-[#052e16]">Rs.{{ number_format($lineTotal) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Clear Cart / Continue --}}
                <div class="flex flex-wrap items-center justify-between gap-4 pt-4">
                    <a href="{{ route('services') }}" class="flex items-center gap-2 text-sm font-black text-slate-500 hover:text-green-700 transition-colors uppercase tracking-widest">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Keep Shopping
                    </a>
                </div>
            </div>

            {{-- ===== RIGHT: Order Summary ===== --}}
            @php
                $total = 0; $totalSavings = 0;
                foreach($cart as $d) {
                    $total += $d['price'] * $d['quantity'];
                    if(!empty($d['is_on_sale'])) $totalSavings += ($d['original_price'] - $d['price']) * $d['quantity'];
                }
            @endphp
            <div class="lg:col-span-5 fade-in fade-in-3">
                <div class="summary-card">

                    {{-- Summary Header --}}
                    <div class="summary-header">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                                <i class="fa-solid fa-receipt text-white text-sm"></i>
                            </div>
                            <h3 class="text-white font-black text-base uppercase tracking-[0.2em]">Order Summary</h3>
                        </div>
                        <p class="text-green-200 text-[10px] font-bold uppercase tracking-widest ml-11">{{ count($cart) }} {{ Str::plural('item', count($cart)) }}</p>
                    </div>

                    <div class="p-7 space-y-5">
                        {{-- Subtotal --}}
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Subtotal</span>
                            <span class="text-sm font-black text-[#052e16]">Rs. {{ number_format($total) }}</span>
                        </div>

                        {{-- Savings --}}
                        @if($totalSavings > 0)
                        <div class="flex justify-between items-center bg-green-50 rounded-xl px-4 py-3 border border-green-100">
                            <span class="text-[11px] font-black text-green-700 uppercase tracking-widest flex items-center gap-2">
                                <i class="fa-solid fa-tag text-xs"></i> You Save
                            </span>
                            <span class="text-sm font-black text-green-700">− Rs. {{ number_format($totalSavings) }}</span>
                        </div>
                        @endif

                        {{-- Shipping --}}
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Delivery</span>
                            @if($progressPct >= 100)
                                <span class="text-[11px] font-black text-green-600 bg-green-50 px-3 py-1 rounded-full border border-green-200">FREE 🎉</span>
                            @else
                                <span class="text-[11px] font-bold text-amber-600">Calculated at checkout</span>
                            @endif
                        </div>

                        {{-- Divider --}}
                        <div class="border-t-2 border-dashed border-slate-100 pt-5">
                            <div class="flex justify-between items-center">
                                <span class="text-base font-black text-[#052e16] uppercase tracking-widest">Total</span>
                                <div class="text-right">
                                    <span class="text-[9px] text-slate-400 font-bold block uppercase">PKR</span>
                                    <span class="text-3xl font-black text-[#052e16] leading-none">{{ number_format($total) }}</span>
                                </div>
                            </div>
                            @if($totalSavings > 0)
                            <p class="text-[10px] text-green-600 font-black mt-1 text-right">You saved Rs. {{ number_format($totalSavings) }} on this order!</p>
                            @endif
                        </div>

                        {{-- Checkout Button --}}
                        <a href="{{ route('cart.checkout') }}" class="checkout-btn">
                            <i class="fa-solid fa-lock text-xs opacity-80"></i>
                            Proceed to Checkout
                            <i class="fa-solid fa-arrow-right-long text-xs"></i>
                        </a>

                        {{-- Continue Shopping --}}
                        <a href="{{ route('services') }}" class="continue-btn">
                            <i class="fa-solid fa-store text-xs"></i>
                            Continue Shopping
                        </a>

                        {{-- Trust Signals --}}
                        <div class="space-y-3 pt-2">
                            <div class="trust-badge">
                                <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-shield-halved text-green-700 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-slate-700 uppercase tracking-widest">100% Secure Checkout</div>
                                    <div class="text-[9px] text-slate-400 font-bold">SSL encrypted & protected</div>
                                </div>
                            </div>
                            <div class="trust-badge">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-rotate-left text-amber-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-slate-700 uppercase tracking-widest">Easy Returns</div>
                                    <div class="text-[9px] text-slate-400 font-bold">7-day hassle-free return policy</div>
                                </div>
                            </div>
                            <div class="trust-badge">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-headset text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-slate-700 uppercase tracking-widest">24/7 Support</div>
                                    <div class="text-[9px] text-slate-400 font-bold">Always here to help you</div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Icons --}}
                        <div class="flex items-center justify-center gap-4 pt-2 opacity-40">
                            <i class="fa-brands fa-cc-visa text-2xl text-slate-600"></i>
                            <i class="fa-brands fa-cc-mastercard text-2xl text-slate-600"></i>
                            <i class="fa-solid fa-money-bill-wave text-xl text-slate-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        {{-- ===== EMPTY CART STATE ===== --}}
        <div class="empty-cart fade-in">
            <div class="empty-icon-ring">
                <i class="fa-solid fa-cart-shopping text-4xl text-green-300"></i>
            </div>
            <h2 class="text-3xl font-black text-[#052e16] uppercase tracking-tight mb-3">Your Cart is Empty</h2>
            <p class="text-slate-400 font-medium mb-10 max-w-sm mx-auto leading-relaxed">Looks like you haven't added anything yet. Explore our premium herbal products!</p>
            <a href="{{ route('services') }}"
               class="inline-flex items-center gap-3 px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.25em] text-white"
               style="background: linear-gradient(135deg, #052e16, #16a34a);">
                <i class="fa-solid fa-store"></i>
                Shop Now
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Quantity Buttons (+ / −) ──────────────────────────────
    document.querySelectorAll('.cart-item-card').forEach(function(card) {
        var qtyDisplay = card.querySelector('.qty-display');
        var hiddenInput = card.querySelector('.quantity');
        var id = card.getAttribute('data-id');
        var currentQty = parseInt(qtyDisplay ? qtyDisplay.textContent : 1);

        function updateQty(newQty) {
            if (newQty < 1) return;
            currentQty = newQty;
            if (qtyDisplay) qtyDisplay.textContent = newQty;
            if (hiddenInput) hiddenInput.value = newQty;

            $.ajax({
                url: '{!! route("cart.update") !!}',
                method: 'PATCH',
                data: { _token: '{!! csrf_token() !!}', id: id, quantity: newQty },
                success: function() { window.location.reload(); }
            });
        }

        var plusBtn = card.querySelector('.qty-plus');
        var minusBtn = card.querySelector('.qty-minus');

        if (plusBtn) plusBtn.addEventListener('click', function() { updateQty(currentQty + 1); });
        if (minusBtn) minusBtn.addEventListener('click', function() { updateQty(Math.max(1, currentQty - 1)); });
    });

    // ── Remove Buttons ────────────────────────────────────────
    document.querySelectorAll('.remove-from-cart').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var card = btn.closest('[data-id]');
            var id = card ? card.getAttribute('data-id') : null;
            if (!id) return;

            // Animate out
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'translateX(-20px)';

            setTimeout(function() {
                $.ajax({
                    url: '{!! route("cart.remove") !!}',
                    method: 'DELETE',
                    data: { _token: '{!! csrf_token() !!}', id: id },
                    success: function() { window.location.reload(); }
                });
            }, 300);
        });
    });
});
</script>
@endpush

</x-app-layout>
