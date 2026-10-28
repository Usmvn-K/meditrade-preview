@php
    $initialCart = [];
    $initialSubtotal = 0;
    $initialTotalQty = 0;
    $sessionCart = session()->get('cart', []);

    foreach ($sessionCart as $id => $item) {
        $price = (float)($item['price'] ?? 0);
        $qty = (int)($item['quantity'] ?? 1);
        $lineTotal = $price * $qty;
        $initialSubtotal += $lineTotal;
        $initialTotalQty += $qty;

        $initialCart[] = [
            'id' => (int)($item['id'] ?? $id),
            'name' => $item['name'] ?? 'Product',
            'price' => $price,
            'formattedPrice' => 'Rs. ' . number_format($price, 0),
            'original_price' => isset($item['original_price']) ? (float)$item['original_price'] : $price,
            'formattedOriginalPrice' => isset($item['original_price']) && (float)$item['original_price'] > $price ? 'Rs. ' . number_format((float)$item['original_price'], 0) : null,
            'is_on_sale' => !empty($item['is_on_sale']),
            'quantity' => $qty,
            'image' => !empty($item['image']) ? $item['image'] : asset('images/placeholder.jpg'),
            'subtotal' => $lineTotal,
            'formattedSubtotal' => 'Rs. ' . number_format($lineTotal, 0),
        ];
    }
@endphp

<!-- Slide-Over Cart Drawer Component -->
<div x-data="cartDrawer()" 
     x-cloak
     @open-cart.window="open()"
     @close-cart.window="close()"
     @cart-updated.window="updateStateFromResponse($event.detail)"
     @keydown.escape.window="close()"
     class="relative z-[9999]"
     aria-labelledby="cart-drawer-title" 
     role="dialog" 
     aria-modal="true">

    <!-- Backdrop Blur Overlay -->
    <div x-show="isOpen"
         x-transition:enter="ease-in-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="close()"
         class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity">
    </div>

    <!-- Slide-over Panel Container -->
    <div x-show="isOpen" 
         class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-6 sm:pl-10">
                
                <!-- Slide-over Panel -->
                <div x-show="isOpen"
                     x-transition:enter="transform transition ease-in-out duration-300 sm:duration-400"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-200 sm:duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="pointer-events-auto w-screen max-w-md bg-white shadow-2xl flex flex-col border-l border-emerald-950/20">

                    <!-- Drawer Header -->
                    <div class="bg-gradient-to-r from-[#022c22] via-[#052e16] to-[#022018] px-6 py-5 text-white flex items-center justify-between border-b border-emerald-800/60 shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-800/70 border border-emerald-500/40 flex items-center justify-center text-amber-400 shadow-inner">
                                <i class="fa-solid fa-cart-shopping text-sm"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 id="cart-drawer-title" class="text-base font-black uppercase tracking-tight text-white font-friendly">
                                        Your Cart
                                    </h2>
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-400/20 border border-amber-300/30 text-[10px] font-black text-amber-300 uppercase tracking-wider" 
                                          x-text="`${itemsCount} ${itemsCount === 1 ? 'item' : 'items'}`">
                                    </span>
                                </div>
                                <p class="text-[10px] text-emerald-200/70 font-medium tracking-wide">
                                    100% Pure Organic & Lab Tested
                                </p>
                            </div>
                        </div>

                        <!-- Close Button -->
                        <button type="button" 
                                @click="close()" 
                                class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all duration-200 hover:rotate-90 active:scale-95 border border-white/10" 
                                aria-label="Close cart drawer">
                            <i class="fa-solid fa-xmark text-base"></i>
                        </button>
                    </div>

                    <!-- Drawer Body -->
                    <div class="flex-1 overflow-y-auto p-5 space-y-4 bg-slate-50/60 relative">
                        
                        <!-- Loading Overlay -->
                        <div x-show="isLoading" 
                             class="absolute inset-0 bg-white/70 backdrop-blur-[2px] z-20 flex items-center justify-center transition-opacity"
                             x-transition>
                            <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-950 text-amber-400 text-xs font-black shadow-xl">
                                <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
                                <span>Updating Cart...</span>
                            </div>
                        </div>

                        <!-- Populated Cart Items List -->
                        <template x-if="itemsCount > 0">
                            <div class="space-y-3">
                                <template x-for="item in items" :key="item.id">
                                    <div class="relative bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-sm hover:border-emerald-300/80 transition-all group flex gap-3.5 items-center">
                                        
                                        <!-- Thumbnail Image -->
                                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 shrink-0 relative">
                                            <img :src="item.image" 
                                                 :alt="item.name" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>

                                        <!-- Item Details -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-2">
                                                <h3 class="text-xs font-black text-slate-900 truncate leading-snug" x-text="item.name"></h3>
                                                <button type="button" 
                                                        @click="removeItem(item.id)" 
                                                        class="text-slate-400 hover:text-rose-600 p-1 transition-colors" 
                                                        title="Remove Item"
                                                        aria-label="Remove item">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>

                                            <div class="flex items-baseline gap-2 mt-1">
                                                <span class="text-xs font-black text-emerald-800" x-text="item.formattedPrice"></span>
                                                <template x-if="item.is_on_sale && item.formattedOriginalPrice">
                                                    <span class="text-[10px] text-slate-400 line-through font-semibold" x-text="item.formattedOriginalPrice"></span>
                                                </template>
                                            </div>

                                            <!-- Quantity Controls & Line Total -->
                                            <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-slate-100">
                                                <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                                                    <button type="button" 
                                                            @click="updateQty(item.id, item.quantity - 1)" 
                                                            class="w-7 h-7 flex items-center justify-center text-slate-600 hover:bg-emerald-800 hover:text-white transition-colors disabled:opacity-30" 
                                                            :disabled="item.quantity <= 1"
                                                            aria-label="Decrease quantity">
                                                        <i class="fa-solid fa-minus text-[9px]"></i>
                                                    </button>
                                                    <span class="w-8 text-center text-xs font-black text-slate-900" x-text="item.quantity"></span>
                                                    <button type="button" 
                                                            @click="updateQty(item.id, item.quantity + 1)" 
                                                            class="w-7 h-7 flex items-center justify-center text-slate-600 hover:bg-emerald-800 hover:text-white transition-colors"
                                                            aria-label="Increase quantity">
                                                        <i class="fa-solid fa-plus text-[9px]"></i>
                                                    </button>
                                                </div>

                                                <span class="text-xs font-black text-slate-900" x-text="item.formattedSubtotal"></span>
                                            </div>
                                        </div>

                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- Empty Cart State -->
                        <template x-if="itemsCount === 0">
                            <div class="h-full flex flex-col items-center justify-center text-center py-8 px-4">
                                <div class="w-20 h-20 rounded-3xl bg-emerald-50 border-2 border-dashed border-emerald-200 flex items-center justify-center text-emerald-600 mb-4 shadow-sm animate-pulse">
                                    <i class="fa-solid fa-basket-shopping text-3xl"></i>
                                </div>
                                
                                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight font-friendly">
                                    Your Cart is Empty
                                </h3>
                                <p class="text-xs text-slate-500 font-medium max-w-xs mt-1 mb-6 leading-relaxed">
                                    Explore our 100% pure organic wild honey and restorative herbal botanical tonics.
                                </p>

                                <!-- Quick Recommendations -->
                                <div class="w-full bg-white rounded-3xl p-4 border border-emerald-100 shadow-sm text-left space-y-3">
                                    <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-800">
                                        <i class="fa-solid fa-sparkles text-amber-500"></i>
                                        <span>Quick Add Bestsellers</span>
                                    </div>

                                    <!-- Quick Add 1: Habibi Natural Honey -->
                                    <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-300 transition-all group">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <img src="{{ asset('uploads/products/Habibi-Honey.png') }}" 
                                                 class="w-12 h-12 rounded-xl object-cover bg-white border border-slate-200 shrink-0 group-hover:scale-105 transition-transform" 
                                                 alt="Habibi Natural Honey">
                                            <div class="min-w-0">
                                                <h4 class="text-xs font-black text-slate-900 truncate">Habibi Natural Honey</h4>
                                                <div class="flex items-baseline gap-1.5">
                                                    <span class="text-xs font-black text-emerald-700">Rs. 1,200</span>
                                                    <span class="text-[9px] text-slate-400 line-through">Rs. 1,500</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                @click="quickAdd(1)" 
                                                class="px-3 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-1.5 shrink-0 shadow-sm active:scale-95">
                                            <i class="fa-solid fa-plus text-[9px]"></i>
                                            <span>Add</span>
                                        </button>
                                    </div>

                                    <!-- Quick Add 2: Habibi Herbal Tonic -->
                                    <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-300 transition-all group">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <img src="{{ asset('uploads/products/habibi-tonic.png') }}" 
                                                 class="w-12 h-12 rounded-xl object-cover bg-white border border-slate-200 shrink-0 group-hover:scale-105 transition-transform" 
                                                 alt="Habibi Herbal Tonic">
                                            <div class="min-w-0">
                                                <h4 class="text-xs font-black text-slate-900 truncate">Habibi Herbal Tonic</h4>
                                                <div class="flex items-baseline gap-1.5">
                                                    <span class="text-xs font-black text-emerald-700">Rs. 1,200</span>
                                                    <span class="text-[9px] text-slate-400 line-through">Rs. 1,500</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                @click="quickAdd(2)" 
                                                class="px-3 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-1.5 shrink-0 shadow-sm active:scale-95">
                                            <i class="fa-solid fa-plus text-[9px]"></i>
                                            <span>Add</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>

                    <!-- Drawer Footer (Visible when itemsCount > 0) -->
                    <template x-if="itemsCount > 0">
                        <div class="p-5 border-t border-slate-200/80 bg-white space-y-3.5 shadow-xl">
                            
                            <!-- Subtotal Calculation -->
                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Subtotal</span>
                                    <span class="text-2xl font-black text-emerald-950 font-friendly" x-text="formattedSubtotal"></span>
                                </div>
                                <p class="text-[10px] text-slate-400 leading-tight">
                                    Taxes & shipping verified at checkout. Cash on delivery nationwide.
                                </p>
                            </div>

                            <!-- Nationwide Cash on Delivery Badge -->
                            <div class="flex items-center justify-center gap-2 py-2 px-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold">
                                <i class="fa-solid fa-truck-fast text-amber-600"></i>
                                <span class="text-[11px] font-black uppercase tracking-wider">Nationwide Cash on Delivery</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-2 pt-1">
                                <!-- Proceed to Checkout Button -->
                                <a href="{{ route('checkout') }}" 
                                   class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-emerald-900 hover:from-emerald-700 hover:to-emerald-800 text-white font-black text-xs uppercase tracking-widest text-center shadow-xl shadow-emerald-900/25 flex items-center justify-center gap-2 group transition-all duration-300 active:scale-[0.98]">
                                    <span>Proceed to Checkout</span>
                                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </a>

                                <!-- Quick Order via WhatsApp -->
                                <a :href="whatsappUrl" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="w-full py-3.5 px-6 rounded-2xl bg-[#25D366] hover:bg-[#20bd5a] text-white font-black text-xs uppercase tracking-widest text-center shadow-md flex items-center justify-center gap-2 transition-all duration-300 active:scale-[0.98]">
                                    <i class="fa-brands fa-whatsapp text-lg"></i>
                                    <span>Quick Order via WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function cartDrawer() {
    return {
        isOpen: false,
        isLoading: false,
        items: @json($initialCart),
        subtotal: {{ (float)$initialSubtotal }},
        formattedSubtotal: 'Rs. {{ number_format($initialSubtotal, 0) }}',

        init() {
            window._cartDrawer = this;
            window.addEventListener('cart-updated', (e) => {
                if (e.detail) {
                    this.updateStateFromResponse(e.detail);
                }
            });
        },

        get itemsCount() {
            return this.items.length;
        },

        get totalQuantity() {
            return this.items.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);
        },

        get whatsappUrl() {
            const phone = '923006423878';
            if (this.itemsCount === 0) {
                return `https://wa.me/${phone}?text=${encodeURIComponent('Hi Habibi Herbal! I would like to place an order via Cash on Delivery.')}`;
            }

            let lines = ['Hi Habibi Herbal! I would like to place an order via Cash on Delivery for:'];
            this.items.forEach(item => {
                lines.push(`• ${item.quantity}x ${item.name} (${item.formattedSubtotal})`);
            });
            lines.push(`\nTotal: ${this.formattedSubtotal}`);
            lines.push('Please confirm my order and shipping details.');

            return `https://wa.me/${phone}?text=${encodeURIComponent(lines.join('\n'))}`;
        },

        open() {
            this.isOpen = true;
            document.body.classList.add('overflow-hidden');
            // Background sync
            this.syncCartData();
        },

        close() {
            this.isOpen = false;
            document.body.classList.remove('overflow-hidden');
        },

        updateStateFromResponse(data) {
            if (!data) return;
            if (Array.isArray(data.cart)) {
                this.items = data.cart;
            }
            if (data.subtotal !== undefined) {
                this.subtotal = data.subtotal;
            }
            if (data.formattedSubtotal) {
                this.formattedSubtotal = data.formattedSubtotal;
            }

            // Sync Navbar badge
            const badge = document.getElementById('navbar-cart-count');
            if (badge) {
                badge.textContent = this.itemsCount;
                badge.classList.remove('scale-125');
                void badge.offsetWidth; // trigger reflow
                badge.classList.add('scale-125');
                setTimeout(() => badge.classList.remove('scale-125'), 300);
            }
        },

        async syncCartData() {
            try {
                const res = await fetch('{{ route('cart.data') }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (res.ok) {
                    const data = await res.json();
                    this.updateStateFromResponse(data);
                }
            } catch (err) {
                console.error('Error syncing cart:', err);
            }
        },

        async quickAdd(serviceId) {
            await window.addToCartAjax(serviceId, 1);
        },

        async updateQty(id, qty) {
            if (qty < 1) return;
            this.isLoading = true;
            const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

            try {
                const res = await fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id: id,
                        quantity: qty,
                        _token: token
                    })
                });

                if (res.ok) {
                    const data = await res.json();
                    this.updateStateFromResponse(data);
                }
            } catch (err) {
                console.error('Error updating cart quantity:', err);
            } finally {
                this.isLoading = false;
            }
        },

        async removeItem(id) {
            this.isLoading = true;
            const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

            try {
                const res = await fetch('{{ route('cart.remove') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id: id,
                        _token: token
                    })
                });

                if (res.ok) {
                    const data = await res.json();
                    this.updateStateFromResponse(data);
                }
            } catch (err) {
                console.error('Error removing item from cart:', err);
            } finally {
                this.isLoading = false;
            }
        }
    };
}

// Global JS Helper Functions
window.openCartDrawer = function() {
    window.dispatchEvent(new CustomEvent('open-cart'));
};

window.closeCartDrawer = function() {
    window.dispatchEvent(new CustomEvent('close-cart'));
};

window.addToCartAjax = async function(serviceId, quantity = 1) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const url = `/add-to-cart/${serviceId}`;

    try {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                quantity: quantity,
                _token: token
            })
        });

        if (res.ok) {
            const data = await res.json();
            
            // Dispatch update event
            window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
            if (window._cartDrawer && typeof window._cartDrawer.updateStateFromResponse === 'function') {
                window._cartDrawer.updateStateFromResponse(data);
            }

            // Update navbar pill directly
            const badge = document.getElementById('navbar-cart-count');
            if (badge && data.cartCount !== undefined) {
                badge.textContent = data.cartCount;
            }

            // Open drawer smoothly
            window.openCartDrawer();
        } else {
            // Fallback: normal navigation if error
            window.location.href = url;
        }
    } catch (err) {
        console.error('Add to cart AJAX error:', err);
        window.location.href = url;
    }
};

// Global click delegator for any cart buttons on the page
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('a[href*="/add-to-cart/"], [data-add-to-cart], .add-to-cart-btn');
        if (!btn) return;

        // Skip if button specifically requests default behavior
        if (btn.hasAttribute('data-no-ajax')) return;

        let serviceId = btn.dataset.productId || btn.dataset.addToCart;
        if (!serviceId && btn.href) {
            const match = btn.href.match(/\/add-to-cart\/(\d+)/);
            if (match) serviceId = match[1];
        }

        if (serviceId) {
            e.preventDefault();
            e.stopPropagation();
            window.addToCartAjax(serviceId);
        }
    });
});
</script>
