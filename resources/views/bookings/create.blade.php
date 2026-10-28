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

        .form-floating input:focus ~ label,
        .form-floating input:not(:placeholder-shown) ~ label {
            transform: translateY(-1.5rem) scale(0.85);
            color: #172554;
            font-weight: 800;
        }

        .step-pill {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .step-pill.active {
            background: #172554;
            color: white;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        /* Perforated Ticket Style */
        .ticket-perforation {
            background-image: radial-gradient(circle at 10px 10px, transparent 10px, white 11px);
            background-size: 100% 20px;
            background-position: center bottom;
            background-repeat: no-repeat;
            padding-bottom: 20px;
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-checkout { animation: slideInUp 0.6s ease-out forwards; }
    </style>
    @endpush

    <div class="min-h-screen checkout-bg py-8 md:py-16 px-4" x-data="checkoutEngine()" x-cloak>
        <div class="max-w-6xl mx-auto">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 animate-checkout">
                <div class="flex items-center gap-5">
                    <a href="{{ route('services.show', $service) }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#172554] hover:border-[#172554]/30 transition-all group">
                        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-black text-[#172554] tracking-tighter uppercase">Checkout</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-1">Order ID: #{{ strtoupper(Str::random(8)) }} • Secure Checkout</p>
                    </div>
                </div>

                <!-- Step Indicators -->
                <div class="flex items-center gap-2 bg-white/50 backdrop-blur-md p-1.5 rounded-2xl border border-white">
                    <template x-for="(label, idx) in ['Identity', 'Details', 'Review']">
                        <div class="step-pill px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest cursor-default"
                             :class="step === idx + 1 ? 'active shadow-lg shadow-blue-500/20' : 'text-slate-400'">
                            <span x-text="label"></span>
                        </div>
                    </template>
                </div>
            </div>

            <div class="grid lg:grid-cols-12 gap-10">
                
                <!-- Main Form Body -->
                <div class="lg:col-span-7 space-y-8 animate-checkout" style="animation-delay: 0.1s">
                    <form @submit.prevent="handleSubmit" action="{{ route('services.store_booking', $service->id) }}" method="POST" id="checkoutForm" class="space-y-8">
                        @csrf
                        
                        <!-- Section 1: Authentication & Identity -->
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
                                <div class="relative form-floating group">
                                    <input type="text" id="customer_name" name="customer_name" x-model="form.customer_name" required placeholder=" "
                                           class="w-full bg-transparent border-0 border-b-2 border-slate-200 py-4 px-0 text-sm font-black text-slate-900 focus:ring-0 focus:border-[#172554] transition-all placeholder-transparent">
                                    <label for="customer_name" class="absolute left-0 -top-3 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] transition-all pointer-events-none group-focus-within:text-[#172554]">Full Name</label>
                                </div>

                                <div class="grid md:grid-cols-2 gap-10">
                                    <div class="relative form-floating group">
                                        <input type="email" id="customer_email" name="customer_email" x-model="form.customer_email" required placeholder=" "
                                               class="w-full bg-transparent border-0 border-b-2 border-slate-200 py-4 px-0 text-sm font-black text-slate-900 focus:ring-0 focus:border-[#172554] transition-all placeholder-transparent">
                                        <label for="customer_email" class="absolute left-0 -top-3 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] transition-all pointer-events-none">Email Address</label>
                                    </div>
                                    <div class="relative form-floating group">
                                        <input type="tel" id="customer_phone" name="customer_phone" x-model="form.customer_phone" required placeholder=" "
                                               class="w-full bg-transparent border-0 border-b-2 border-slate-200 py-4 px-0 text-sm font-black text-slate-900 focus:ring-0 focus:border-[#172554] transition-all placeholder-transparent">
                                        <label for="customer_phone" class="absolute left-0 -top-3 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] transition-all pointer-events-none">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Order Specs -->
                        <div class="premium-glass rounded-[2.5rem] p-8 md:p-10">
                            <div class="flex items-center gap-4 mb-10">
                                <div class="w-12 h-12 rounded-2xl bg-[#dc2626] text-white flex items-center justify-center shadow-xl shadow-red-900/20">
                                    <i class="fa-solid fa-layer-group text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-black text-[#172554] uppercase tracking-tight">Order Configuration</h2>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Select quantity and variations</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-10">
                                <!-- Quantity Controller -->
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Quantity</label>
                                    <div class="flex items-center justify-between bg-white rounded-2xl p-2 border border-slate-100 shadow-sm">
                                        <button type="button" @click="form.guest_count = Math.max(1, form.guest_count - 1)" 
                                                class="w-12 h-12 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#172554] hover:text-white transition-all flex items-center justify-center">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span class="text-xl font-black text-[#172554]" x-text="form.guest_count"></span>
                                        <input type="hidden" name="guest_count" x-model="form.guest_count">
                                        <button type="button" @click="form.guest_count++" 
                                                class="w-12 h-12 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#172554] hover:text-white transition-all flex items-center justify-center">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Variation Select -->
                                @if(!empty($service->packages))
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Variation</label>
                                    <div class="relative">
                                        <select x-model="form.package_name" name="package_name" class="w-full h-16 bg-white rounded-2xl px-6 border border-slate-100 shadow-sm text-sm font-bold text-slate-900 appearance-none focus:ring-2 focus:ring-[#172554]/20 outline-none">
                                            <option value="">Standard Edition</option>
                                            @foreach($service->packages as $pkg)
                                                <option value="{{ $pkg['name'] }}">{{ $pkg['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none"></i>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Destination Address -->
                            <div class="mt-10 space-y-4">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Shipping Address</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-location-dot absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#172554] transition-colors"></i>
                                    <input type="text" name="event_location" x-model="form.event_location" required placeholder="Complete address for delivery"
                                           class="w-full h-16 bg-white rounded-2xl pl-14 pr-6 border border-slate-100 shadow-sm text-sm font-bold text-slate-900 focus:ring-2 focus:ring-[#172554]/20 outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Matrix -->
                        <div class="pt-6">
                            <button type="submit" :disabled="isSubmitting"
                                    class="w-full group relative bg-[#172554] text-white py-6 rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] overflow-hidden shadow-2xl shadow-blue-900/30 hover:-translate-y-1 transition-all disabled:opacity-50">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                <span class="relative z-10 flex items-center justify-center gap-4">
                                    <span x-show="!isSubmitting">Complete Order</span>
                                    <span x-show="isSubmitting" class="flex items-center gap-3">
                                        <i class="fa-solid fa-circle-notch fa-spin"></i> Processing Secure Payment
                                    </span>
                                    <i class="fa-solid fa-bolt text-[#dc2626]" x-show="!isSubmitting"></i>
                                </span>
                            </button>
                            
                            <p class="text-center text-[8px] font-black text-slate-400 uppercase tracking-[0.4em] mt-8">
                                <i class="fa-solid fa-shield-halved mr-2 text-green-500"></i> Secure 256-bit SSL Encrypted Transaction
                            </p>
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="total_price" :value="estimatedCost">
                    </form>
                </div>

                <!-- Right Side: Order Summary Ticket -->
                <div class="lg:col-span-5 animate-checkout" style="animation-delay: 0.2s">
                    <div class="sticky top-24">
                        <div class="bg-white rounded-[2.5rem] shadow-[0_40px_80px_-15px_rgba(0,0,0,0.1)] overflow-hidden">
                            <!-- Digital Header -->
                            <div class="bg-[#172554] p-10 text-white relative">
                                <div class="absolute top-0 right-0 p-8 opacity-5">
                                    <i class="fa-solid fa-shopping-bag text-8xl"></i>
                                </div>
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-8">
                                        <h2 class="text-xl font-black italic">GOHAR MART</h2>
                                        <div class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg text-[8px] font-black uppercase tracking-widest border border-white/10">Summary</div>
                                    </div>
                                    <h3 class="text-2xl font-black uppercase tracking-tight leading-tight">{{ $service->name }}</h3>
                                    <div class="flex items-center gap-3 mt-4">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Premium Product</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Perforation Line -->
                            <div class="relative h-px border-t-2 border-dashed border-slate-100 my-0 mx-6">
                                <div class="absolute -left-10 -top-4 w-8 h-8 bg-slate-50 rounded-full"></div>
                                <div class="absolute -right-10 -top-4 w-8 h-8 bg-slate-50 rounded-full"></div>
                            </div>

                            <div class="p-10 space-y-8">
                                <!-- Line Items -->
                                <div class="space-y-5">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Base Price</span>
                                        <span class="text-sm font-black text-slate-900">Rs. {{ number_format($service->getCurrentPrice()) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center" x-show="form.guest_count > 1">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Quantity</span>
                                        <span class="text-sm font-black text-slate-900" x-text="'x' + form.guest_count"></span>
                                    </div>
                                    <div class="flex justify-between items-center" x-show="form.package_name">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Variation</span>
                                        <span class="text-[10px] font-black text-primary-900 uppercase tracking-widest bg-primary-50 px-3 py-1 rounded-full" x-text="form.package_name"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Delivery</span>
                                        <span class="text-[10px] font-black text-green-500 uppercase tracking-widest">Free Shipping</span>
                                    </div>
                                </div>

                                <!-- Promo Code Input -->
                                <div class="pt-8 border-t border-slate-50">
                                    <div class="relative group">
                                        <input type="text" x-model="couponCode" placeholder="PROMO CODE" :disabled="appliedCoupon"
                                               class="w-full h-14 bg-slate-50 rounded-xl px-6 text-[10px] font-black tracking-widest uppercase border-0 focus:ring-2 focus:ring-primary-900/10 transition-all">
                                        <button type="button" @click="applyCoupon" x-show="!appliedCoupon"
                                                class="absolute right-2 top-2 bottom-2 px-6 bg-primary-900 text-white text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-secondary-600 transition-colors">
                                            Apply
                                        </button>
                                        <button type="button" @click="removeCoupon" x-show="appliedCoupon"
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-red-500">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </button>
                                    </div>
                                    <p x-show="couponError" class="text-[9px] font-bold text-red-500 mt-2 ml-2 uppercase tracking-widest" x-text="couponError"></p>
                                </div>

                                <!-- Grand Final -->
                                <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-100 shadow-inner">
                                    <div class="flex justify-between items-end mb-2" x-show="discountAmount > 0">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Discount</span>
                                        <span class="text-xs font-black text-emerald-600">- Rs. <span x-text="discountAmount.toLocaleString()"></span></span>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <p class="text-[10px] font-black text-primary-900 uppercase tracking-[0.4em] mb-1">Total Amount</p>
                                            <h4 class="text-3xl font-black text-slate-900 leading-none">
                                                <span class="text-xs font-medium text-slate-400 mr-1 uppercase">Rs.</span>
                                                <span x-text="estimatedCost.toLocaleString()"></span>
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
            Alpine.data('checkoutEngine', () => ({
                step: 1,
                isSubmitting: false,
                form: {
                    customer_name: {!! json_encode(optional(Auth::user())->name ?? "") !!},
                    customer_phone: '',
                    customer_email: {!! json_encode(optional(Auth::user())->email ?? "") !!},
                    guest_count: 1,
                    package_name: '',
                    event_location: '',
                },

                packages: {!! json_encode($service->packages ?? []) !!},
                basePrice: {{ $service->getCurrentPrice() ?? 0 }},
                serviceId: {{ $service->id }},

                couponCode: '',
                appliedCoupon: null,
                isApplyingCoupon: false,
                couponError: '',

                init() {
                    // Auto-step logic
                },

                applyCoupon() {
                    if(!this.couponCode) return;
                    this.isApplyingCoupon = true;
                    this.couponError = '';
                    fetch({!! json_encode(route("coupons.validate")) !!}, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': {!! json_encode(csrf_token()) !!}
                        },
                        body: JSON.stringify({
                            code: this.couponCode,
                            amount: this.rawSubtotal,
                            service_id: this.serviceId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.valid) {
                            this.appliedCoupon = { code: this.couponCode, discount: data.discount };
                        } else {
                            this.couponError = data.message;
                        }
                    })
                    .finally(() => { this.isApplyingCoupon = false; });
                },

                removeCoupon() {
                    this.appliedCoupon = null;
                    this.couponCode = '';
                },

                get rawSubtotal() {
                    let price = this.basePrice;
                    if (this.form.package_name) {
                        const pkg = this.packages.find(p => p.name === this.form.package_name);
                        if (pkg) price = parseFloat(pkg.price);
                    }
                    return price * Math.max(1, this.form.guest_count);
                },

                get discountAmount() {
                    return this.appliedCoupon ? this.appliedCoupon.discount : 0;
                },

                get estimatedCost() {
                    return Math.max(0, this.rawSubtotal - this.discountAmount);
                },

                handleSubmit() {
                    this.isSubmitting = true;
                    document.getElementById('checkoutForm').submit();
                }
            }));
        });
    </script>
</x-app-layout>

