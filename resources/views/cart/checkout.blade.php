<x-app-layout>
    @push('styles')
    <style>
        .checkout-bg {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(23, 37, 84, 0.03) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(220, 38, 38, 0.03) 0, transparent 50%);
        }
        .premium-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-checkout { animation: slideInUp 0.6s ease-out forwards; }
    </style>
    @endpush

    <div class="min-h-screen checkout-bg py-8 md:py-16 px-4" x-data="cartCheckout()" x-cloak>
        <div class="max-w-6xl mx-auto">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 animate-checkout">
                <div class="flex items-center gap-5">
                    <a href="{{ route('cart.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#172554] hover:border-[#172554]/30 transition-all group">
                        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-black text-[#172554] tracking-tighter uppercase">Checkout</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-1">
                            Order ID: #{{ strtoupper(Str::random(8)) }} • {{ count($cart) }} Item(s) • Secure Checkout
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-12 gap-10">
                
                <!-- Main Form -->
                <div class="lg:col-span-7 space-y-8 animate-checkout" style="animation-delay: 0.1s">
                    <form action="{{ route('cart.placeOrder') }}" method="POST" id="checkoutForm" class="space-y-8">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="premium-glass rounded-[2.5rem] p-8 md:p-10 pt-14">
                            <div class="flex items-center gap-4 mb-10">
                                <div class="w-12 h-12 rounded-2xl bg-[#172554] text-white flex items-center justify-center shadow-xl shadow-blue-900/20">
                                    <i class="fa-solid fa-user-shield text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-black text-[#172554] uppercase tracking-tight">Personal Information</h2>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Required for order verification</p>
                                </div>
                            </div>

                            <div class="space-y-10">
                                <div class="relative group">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Full Name</label>
                                    <input type="text" name="customer_name" value="{{ optional(Auth::user())->name }}" required
                                           class="w-full bg-transparent border-0 border-b-2 border-slate-200 py-4 px-0 text-sm font-black text-slate-900 focus:ring-0 focus:border-[#172554] transition-all">
                                </div>

                                <div class="grid md:grid-cols-2 gap-10">
                                    <div class="relative group">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Email Address</label>
                                        <input type="email" name="customer_email" value="{{ optional(Auth::user())->email }}" required
                                               class="w-full bg-transparent border-0 border-b-2 border-slate-200 py-4 px-0 text-sm font-black text-slate-900 focus:ring-0 focus:border-[#172554] transition-all">
                                    </div>
                                    <div class="relative group">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Phone Number</label>
                                        <input type="tel" name="customer_phone" required
                                               class="w-full bg-transparent border-0 border-b-2 border-slate-200 py-4 px-0 text-sm font-black text-slate-900 focus:ring-0 focus:border-[#172554] transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="premium-glass rounded-[2.5rem] p-8 md:p-10">
                            <div class="flex items-center gap-4 mb-10">
                                <div class="w-12 h-12 rounded-2xl bg-[#dc2626] text-white flex items-center justify-center shadow-xl shadow-red-900/20">
                                    <i class="fa-solid fa-truck-fast text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-black text-[#172554] uppercase tracking-tight">Shipping Details</h2>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Where should we deliver?</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="relative group">
                                    <i class="fa-solid fa-location-dot absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#172554] transition-colors"></i>
                                    <input type="text" name="shipping_address" required placeholder="Complete address for delivery"
                                           class="w-full h-16 bg-white rounded-2xl pl-14 pr-6 border border-slate-100 shadow-sm text-sm font-bold text-slate-900 focus:ring-2 focus:ring-[#172554]/20 outline-none">
                                </div>
                                <div class="relative group">
                                    <i class="fa-solid fa-note-sticky absolute left-6 top-5 text-slate-300 group-focus-within:text-[#172554] transition-colors"></i>
                                    <textarea name="notes" rows="3" placeholder="Order notes (optional)"
                                              class="w-full bg-white rounded-2xl pl-14 pr-6 py-4 border border-slate-100 shadow-sm text-sm font-bold text-slate-900 focus:ring-2 focus:ring-[#172554]/20 outline-none resize-none"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-6">
                            <button type="submit" id="submitBtn"
                                    class="w-full group relative bg-[#172554] text-white py-6 rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] overflow-hidden shadow-2xl shadow-blue-900/30 hover:-translate-y-1 transition-all disabled:opacity-50">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                <span class="relative z-10 flex items-center justify-center gap-4">
                                    <span>Complete Order</span>
                                    <i class="fa-solid fa-bolt text-[#dc2626]"></i>
                                </span>
                            </button>
                            
                            <p class="text-center text-[8px] font-black text-slate-400 uppercase tracking-[0.4em] mt-8">
                                <i class="fa-solid fa-shield-halved mr-2 text-green-500"></i> Secure 256-bit SSL Encrypted Transaction
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Right Side: Order Summary -->
                <div class="lg:col-span-5 animate-checkout" style="animation-delay: 0.2s">
                    <div class="sticky top-24">
                        <div class="bg-white rounded-[2.5rem] shadow-[0_40px_80px_-15px_rgba(0,0,0,0.1)] overflow-hidden">
                            <!-- Header -->
                            <div class="bg-[#172554] p-8 text-white relative">
                                <div class="absolute top-0 right-0 p-8 opacity-5">
                                    <i class="fa-solid fa-shopping-bag text-8xl"></i>
                                </div>
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-4">
                                        <h2 class="text-xl font-black italic">GOHAR MART</h2>
                                        <div class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg text-[8px] font-black uppercase tracking-widest border border-white/10">
                                            {{ count($cart) }} Items
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Order Summary</p>
                                </div>
                            </div>

                            <!-- Perforation -->
                            <div class="relative h-px border-t-2 border-dashed border-slate-100 my-0 mx-6">
                                <div class="absolute -left-10 -top-4 w-8 h-8 bg-slate-50 rounded-full"></div>
                                <div class="absolute -right-10 -top-4 w-8 h-8 bg-slate-50 rounded-full"></div>
                            </div>

                            <div class="p-8 space-y-6">
                                <!-- Cart Items List -->
                                @foreach($cart as $id => $details)
                                <div class="flex items-center gap-4 pb-4 {{ !$loop->last ? 'border-b border-slate-50' : '' }}">
                                     <img src="{{ $details['image'] ?? 'https://via.placeholder.com/56' }}" 
                                          class="w-14 h-14 rounded-xl object-cover shadow-sm flex-shrink-0"
                                          onerror="this.src='https://via.placeholder.com/56?text=Img'">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs font-black text-[#172554] uppercase truncate">{{ $details['name'] }}</h4>
                                        <p class="text-[10px] text-slate-400 font-bold">Qty: {{ $details['quantity'] }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        @if(!empty($details['is_on_sale']))
                                            <span class="text-[10px] text-slate-400 line-through block">Rs. {{ number_format($details['original_price'] * $details['quantity']) }}</span>
                                            <span class="text-sm font-black text-red-600">Rs. {{ number_format($details['price'] * $details['quantity']) }}</span>
                                        @else
                                            <span class="text-sm font-black text-slate-900">Rs. {{ number_format($details['price'] * $details['quantity']) }}</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach

                                <!-- Totals -->
                                <div class="space-y-4 pt-4 border-t border-slate-100">
                                    @if($savings > 0)
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">You Save</span>
                                        <span class="text-xs font-black text-emerald-600">- Rs. {{ number_format($savings) }}</span>
                                    </div>
                                    @endif
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Delivery</span>
                                        <span class="text-[10px] font-black text-green-500 uppercase tracking-widest">Free Shipping</span>
                                    </div>
                                </div>

                                <!-- Grand Total -->
                                <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-100 shadow-inner">
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <p class="text-[10px] font-black text-primary-900 uppercase tracking-[0.4em] mb-1">Total Amount</p>
                                            <h4 class="text-3xl font-black text-slate-900 leading-none">
                                                <span class="text-xs font-medium text-slate-400 mr-1 uppercase">Rs.</span>
                                                {{ number_format($total) }}
                                            </h4>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex gap-1">
                                                <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse" style="animation-delay: 0.2s"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse" style="animation-delay: 0.4s"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="mt-8 flex justify-center items-center gap-8 opacity-20 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-700">
                            <i class="fa-brands fa-cc-visa text-3xl"></i>
                            <i class="fa-brands fa-cc-mastercard text-3xl"></i>
                            <i class="fa-brands fa-cc-stripe text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cartCheckout', () => ({
                init() {
                    const form = document.getElementById('checkoutForm');
                    form.addEventListener('submit', function() {
                        document.getElementById('submitBtn').disabled = true;
                        document.getElementById('submitBtn').innerHTML = '<span class="relative z-10 flex items-center justify-center gap-3"><i class="fa-solid fa-circle-notch fa-spin"></i> Processing Order...</span>';
                    });
                }
            }));
        });
    </script>
</x-app-layout>
