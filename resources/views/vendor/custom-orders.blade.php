<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-primary-900 leading-tight uppercase tracking-tighter">
                    <i class="fa-solid fa-boxes-packing text-secondary-600 mr-2"></i>{{ __('Bulk Retail Orders') }}
                </h2>
                <p class="text-gray-500 text-xs mt-1 font-black uppercase tracking-widest">Manage high-volume inventory requests and distribution</p>
            </div>
            <a href="{{ route('vendor.dashboard') }}" class="bg-white border border-gray-100 hover:bg-primary-900 hover:text-white text-primary-900 font-black uppercase text-xs tracking-widest py-3 px-6 rounded-xl transition-all flex items-center gap-2 shadow-sm hover:shadow-lg">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="flex items-center gap-3 bg-white px-5 py-2.5 rounded-xl shadow-sm border border-gray-100 ml-auto">
                    <div class="w-2.5 h-2.5 bg-secondary-600 rounded-full animate-ping"></div>
                    <span class="text-[10px] font-black text-primary-900 uppercase tracking-widest">Real-time Feed</span>
                </div>
            </div>

            @if($bookings->isEmpty())
                <div class="bg-white rounded-[2.5rem] p-20 text-center border border-gray-100 shadow-xl shadow-blue-900/5 relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="w-24 h-24 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-8 text-gray-200 group-hover:scale-110 group-hover:bg-primary-50 group-hover:text-primary-900 transition-all duration-700">
                            <i class="fa-solid fa-cubes text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-primary-900 mb-3 uppercase tracking-tighter">No Bulk Requests Found</h3>
                        <p class="text-gray-400 max-w-md mx-auto font-medium">When high-volume orders are placed for your inventory, they will appear here with specialized logistics details.</p>
                    </div>
                </div>
            @else
                <div class="space-y-8">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-blue-900/5 border border-gray-100 hover:border-primary-900 transition-all duration-700 group relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity transform group-hover:scale-125 duration-1000">
                                <i class="fa-solid fa-truck-fast text-[12rem]"></i>
                            </div>

                            <div class="relative z-10 grid lg:grid-cols-4 gap-10">
                                <!-- Order Info -->
                                <div class="lg:col-span-1 space-y-6">
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-900 text-white rounded-lg text-[10px] font-black uppercase tracking-widest">
                                        <i class="fa-solid fa-barcode text-xs"></i> Transaction ID #{{ $booking->id }}
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Fulfillment Target</p>
                                        <div class="flex items-center gap-3 text-primary-900">
                                            <i class="fa-regular fa-calendar-check text-secondary-600 text-lg"></i>
                                            <span class="font-black text-sm uppercase">{{ $booking->booking_date->format('d M, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-400 text-[10px] mt-2 font-black uppercase tracking-widest">
                                            <i class="fa-regular fa-clock"></i>
                                            <span>{{ $booking->booking_date->format('h:i A') }} Protocol</span>
                                        </div>
                                    </div>
                                    
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'confirmed' => 'bg-primary-50 text-primary-900 border-primary-100',
                                            'completed' => 'bg-green-50 text-green-700 border-green-100',
                                            'cancelled' => 'bg-secondary-50 text-secondary-600 border-secondary-100',
                                        ];
                                        $class = $statusClasses[$booking->status] ?? $statusClasses['pending'];
                                    @endphp
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $class }} shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                        {{ $booking->status }}
                                    </span>
                                </div>

                                <!-- Customer & Product -->
                                <div class="lg:col-span-1 space-y-8 border-l border-gray-100 pl-10">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Inventory Asset</p>
                                        <p class="font-black text-primary-900 uppercase text-xs tracking-tight">{{ $booking->service->name }}</p>
                                        <div class="mt-3 inline-block bg-slate-50 px-3 py-1 rounded border border-slate-100">
                                            <p class="text-[10px] text-secondary-600 font-black uppercase tracking-widest">Rs. {{ number_format($booking->budget) }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Acquisition Agent</p>
                                        <p class="font-black text-primary-900 uppercase text-xs tracking-tight">{{ $booking->customer_name }}</p>
                                        <a href="tel:{{ $booking->customer_phone }}" class="text-[10px] font-black text-gray-400 hover:text-secondary-600 transition-colors flex items-center gap-2 mt-2 uppercase tracking-widest">
                                            <i class="fa-solid fa-phone-flip text-[9px]"></i> {{ $booking->customer_phone }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Logistics Context -->
                                <div class="lg:col-span-2 space-y-8">
                                    <div class="bg-slate-50/80 rounded-3xl p-8 border border-slate-100 relative overflow-hidden">
                                        <div class="absolute top-0 right-0 p-4 opacity-5">
                                            <i class="fa-solid fa-file-invoice text-5xl"></i>
                                        </div>
                                        <p class="text-[10px] font-black text-primary-900 uppercase tracking-[0.2em] mb-5 flex items-center gap-2 relative z-10">
                                            <span class="w-1.5 h-1.5 bg-secondary-600 rounded-full"></span> Logistics Brief
                                        </p>
                                        
                                        <div class="grid sm:grid-cols-2 gap-y-6 gap-x-10 relative z-10">
                                            @php
                                                $standardKeys = ['package_booking_id', 'is_custom_package'];
                                                $customData = array_diff_key($booking->booking_data ?? [], array_flip($standardKeys));
                                            @endphp

                                            @forelse($customData as $key => $value)
                                                <div>
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ str_replace('_', ' ', $key) }}</p>
                                                    <p class="font-black text-primary-900 text-[11px] uppercase tracking-tight leading-tight">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                                </div>
                                            @empty
                                                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">No specific constraints.</p>
                                            @endforelse

                                            @if($booking->notes)
                                                <div class="col-span-full mt-2 pt-5 border-t border-slate-200">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Customer Directive</p>
                                                    <p class="text-xs font-bold text-gray-600 leading-relaxed italic">"{{ $booking->notes }}"</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Logistics Partners -->
                                    <div class="bg-primary-50/50 rounded-3xl p-8 border border-primary-100">
                                        <p class="text-[10px] font-black text-primary-900 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-primary-900 rounded-full"></span> Supply Chain Partners
                                        </p>
                                        
                                        <div class="space-y-4">
                                            @php
                                                $siblings = $booking->siblings();
                                            @endphp
                                            
                                            @forelse($siblings as $sibling)
                                                <div class="flex items-center justify-between bg-white px-5 py-4 rounded-2xl border border-primary-50 shadow-sm hover:shadow-md transition-shadow">
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-10 h-10 bg-primary-900 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-900/10">
                                                            <i class="fa-solid fa-{{ $sibling->service->category->icon ?? 'box' }} text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-[11px] font-black text-primary-900 uppercase tracking-tight">{{ $sibling->service->name }}</p>
                                                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">{{ $sibling->vendor->name ?? 'Global Partner' }}</p>
                                                        </div>
                                                    </div>
                                                    <span class="px-3 py-1 bg-slate-50 border border-slate-100 rounded-lg text-[9px] font-black text-gray-500 uppercase tracking-widest">{{ $sibling->status }}</span>
                                                </div>
                                            @empty
                                                <p class="text-[10px] text-primary-900 font-black uppercase tracking-widest italic opacity-50">Single-asset transaction.</p>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-50">
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('vendor.orders.update', $booking) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="px-6 py-3 bg-white border border-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-secondary-600 hover:text-white hover:border-secondary-600 transition-all shadow-sm">
                                                    Reject
                                                </button>
                                            </form>
                                            <form action="{{ route('vendor.orders.update', $booking) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="px-8 py-3 bg-primary-900 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-secondary-600 shadow-xl shadow-blue-900/10 hover:shadow-red-900/10 transition-all transform hover:-translate-y-1">
                                                    Accept Asset Sale
                                                </button>
                                            </form>
                                        @else
                                            <div class="flex items-center gap-2 px-6 py-3 bg-slate-50 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-xl border border-slate-100">
                                                <i class="fa-solid fa-circle-check"></i>
                                                Archived Transaction
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-12">
                        {{ $bookings->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


