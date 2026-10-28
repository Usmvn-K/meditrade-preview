<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-primary-900 uppercase tracking-tighter leading-tight">
                    {{ __('Order Manifest') }}
                </h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-1">Global Transaction History</p>
            </div>
            <a href="{{ route('home') }}" class="bg-primary-900 hover:bg-secondary-600 text-white font-black py-2.5 px-6 rounded-xl shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5 uppercase tracking-widest text-[10px]">
                <i class="fa-solid fa-cart-plus mr-1"></i> New Acquisition
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen" x-data="{ ratingModalOpen: false, selectedBookingId: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($bookings->isEmpty())
                <div class="text-center py-20 bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary-50 rounded-full translate-x-1/2 -translate-y-1/2 opacity-20"></div>
                    <div class="bg-primary-50 text-primary-900 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 transform transition-transform hover:scale-110 relative z-10">
                        <i class="fa-solid fa-box-open text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-primary-900 uppercase tracking-tighter mb-2 relative z-10">Empty Manifest</h3>
                    <p class="text-slate-500 mb-8 max-w-md mx-auto font-medium relative z-10">You have no active orders in the ecosystem. Start exploring our elite catalog to acquire premium assets.</p>
                    <a href="{{ route('home') }}" class="inline-block bg-primary-900 hover:bg-secondary-600 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-primary-900/10 transition-all uppercase tracking-widest text-xs relative z-10">
                        Explore Collection
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 group flex flex-col transform hover:-translate-y-2">
                            <!-- Header with Date -->
                            <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex justify-between items-center">
                                <div class="flex items-center text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fa-solid fa-clock-rotate-left mr-2 text-primary-900"></i>
                                    {{ $booking->created_at->format('M d, Y') }}
                                </div>
                                <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fa-solid fa-qrcode mr-2 text-primary-900"></i>
                                    ID:{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="p-8 flex-1">
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex-1">
                                        <h4 class="text-xl font-black text-primary-900 uppercase tracking-tighter group-hover:text-secondary-600 transition-colors line-clamp-1">{{ $booking->service->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1.5 flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                            Store: <span class="text-primary-900">Verified Partner</span>
                                        </p>
                                    </div>
                                    <div class="text-right ml-4">
                                        <span class="block text-xl font-black text-primary-900">Rs. {{ number_format($booking->total_price) }}</span>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="flex flex-wrap gap-2 mb-8">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-amber-500', 'label' => 'Awaiting Verification', 'icon' => 'fa-hourglass-half'],
                                            'confirmed' => ['bg' => 'bg-primary-900', 'label' => 'Quality Check', 'icon' => 'fa-shield-check'],
                                            'completed' => ['bg' => 'bg-emerald-500', 'label' => 'Fulfilled', 'icon' => 'fa-check-double'],
                                            'cancelled' => ['bg' => 'bg-secondary-600', 'label' => 'Terminated', 'icon' => 'fa-ban'],
                                        ];
                                        $conf = $statusConfig[$booking->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <div class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $conf['bg'] }} text-white shadow-lg shadow-{{ str_replace('bg-', '', $conf['bg']) }}/10">
                                        <i class="fa-solid {{ $conf['icon'] }} mr-2"></i>
                                        {{ $conf['label'] }}
                                    </div>
                                </div>

                                <!-- Progress Timeline -->
                                <div class="mb-4 px-2">
                                    <div class="flex items-center justify-between relative">
                                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-[3px] bg-slate-100 -z-0 rounded-full"></div>
                                        @php
                                            $steps = [
                                                'pending' => ['label' => 'Ordered', 'icon' => 'fa-receipt', 'color' => 'bg-amber-500'],
                                                'confirmed' => ['label' => 'Processing', 'icon' => 'fa-box-open', 'color' => 'bg-primary-900'],
                                                'completed' => ['label' => 'Delivered', 'icon' => 'fa-truck-fast', 'color' => 'bg-emerald-500']
                                            ];
                                            $currentStatus = $booking->status === 'cancelled' ? 'pending' : $booking->status;
                                        @endphp
                                        
                                        @foreach($steps as $key => $step)
                                            @php
                                                $isPast = false;
                                                $isCurrent = ($currentStatus === $key);
                                                if($currentStatus === 'confirmed' && $key === 'pending') $isPast = true;
                                                if($currentStatus === 'completed') $isPast = true;
                                                $isActive = $isPast || $isCurrent;
                                            @endphp
                                            <div class="relative z-10 flex flex-col items-center">
                                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-700 {{ $isActive ? $step['color'] . ' text-white scale-110 shadow-xl' : 'bg-white text-slate-200 border-2 border-slate-100' }}">
                                                    <i class="fa-solid {{ $step['icon'] }} text-xs"></i>
                                                </div>
                                                <span class="absolute top-12 whitespace-nowrap text-[8px] font-black uppercase tracking-[0.15em] {{ $isActive ? 'text-primary-900' : 'text-slate-300' }}">{{ $step['label'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Action Footer -->
                            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 mt-auto">
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div class="flex gap-4">
                                        <a href="{{ route('bookings.invoice', $booking) }}" class="w-10 h-10 bg-white border border-slate-200 text-slate-400 hover:text-primary-900 hover:border-primary-900 rounded-xl flex items-center justify-center transition-all shadow-sm group/btn" title="Download Invoice">
                                            <i class="fa-solid fa-file-invoice text-sm"></i>
                                        </a>
                                        <a href="{{ route('messages.index', $booking->service->user) }}" class="w-10 h-10 bg-white border border-slate-200 text-slate-400 hover:text-secondary-600 hover:border-secondary-600 rounded-xl flex items-center justify-center transition-all shadow-sm group/btn" title="Contact Support">
                                            <i class="fa-solid fa-headset text-sm"></i>
                                        </a>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        @if($booking->status === 'completed' && !$booking->review)
                                            <button @click="ratingModalOpen = true; selectedBookingId = {{ $booking->id }}" class="bg-primary-900 hover:bg-secondary-600 text-white font-black py-2.5 px-6 rounded-xl shadow-lg transition-all text-[9px] uppercase tracking-widest flex items-center gap-2">
                                                <i class="fa-solid fa-star"></i> Rate Experience
                                            </button>
                                        @elseif($booking->status === 'pending')
                                            <span class="text-[9px] font-black text-amber-500 uppercase tracking-widest flex items-center gap-2">
                                                <i class="fa-solid fa-circle-dot animate-pulse"></i> In Verification
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Premium Review Modal -->
            <div x-cloak x-show="ratingModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-primary-900/40 backdrop-blur-md" @click="ratingModalOpen = false"></div>
                <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-lg z-10 p-10 transform transition-all border border-white/20">
                    <div class="text-center mb-10">
                        <div class="w-20 h-20 bg-primary-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-primary-900">
                            <i class="fa-solid fa-star-sharp text-3xl"></i>
                        </div>
                        <h3 class="text-3xl font-black text-primary-900 uppercase tracking-tighter mb-2">Quality Audit</h3>
                        <p class="text-slate-400 text-sm font-medium">Rate the fulfillment quality of your acquisition</p>
                    </div>
                    
                    <form :action="'/bookings/' + selectedBookingId + '/reviews'" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                        @csrf
                        <div class="flex justify-center mb-10 gap-3">
                            <template x-for="star in 5">
                                <button type="button" 
                                    @click="rating = star" 
                                    @mouseover="hoverRating = star" 
                                    @mouseleave="hoverRating = 0" 
                                    class="text-4xl focus:outline-none transition-all duration-300 transform hover:scale-125"
                                    :class="(hoverRating >= star || (!hoverRating && rating >= star)) ? 'text-secondary-600 drop-shadow-lg' : 'text-slate-100'">
                                    <i class="fa-solid fa-star"></i>
                                </button>
                            </template>
                            <input type="hidden" name="rating" x-model="rating">
                        </div>

                        <div class="mb-8">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Fulfillment Notes</label>
                            <textarea name="comment" rows="4" class="w-full rounded-2xl border-slate-100 bg-slate-50 shadow-inner focus:border-primary-900 focus:ring-primary-900 text-slate-700 font-medium placeholder-slate-300 p-5" placeholder="Document your technical experience with this acquisition..."></textarea>
                        </div>
                        
                        <div class="flex gap-4">
                            <button type="button" @click="ratingModalOpen = false" class="flex-1 py-4 bg-slate-100 text-slate-400 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-200 transition-colors">Abort</button>
                            <button type="submit" :disabled="rating === 0" class="flex-2 py-4 bg-primary-900 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-secondary-600 shadow-xl shadow-primary-900/20 disabled:opacity-50 disabled:cursor-not-allowed transition-all">Submit Audit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>

