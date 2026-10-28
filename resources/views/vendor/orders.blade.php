<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-primary-900 uppercase tracking-tighter leading-tight">
                {{ __('Manage Orders') }}
            </h2>
            <div class="flex gap-2">
                <span class="px-4 py-2 bg-primary-50 text-primary-900 rounded-lg text-[10px] font-black uppercase tracking-widest border border-primary-100 flex items-center">
                    <i class="fa-solid fa-list-check mr-2"></i> All Transactions
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                    <div>
                        <h3 class="text-xl font-black text-primary-900 uppercase tracking-tighter">Retail Orders</h3>
                        <p class="text-sm text-gray-500 font-medium">Manage your retail sales and track fulfillment status.</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-1.5 flex shadow-sm">
                        <button class="px-5 py-2 bg-primary-900 text-white rounded-lg text-[10px] font-black uppercase tracking-widest shadow-lg">All</button>
                        <button class="px-5 py-2 text-gray-400 hover:text-primary-900 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">Pending</button>
                        <button class="px-5 py-2 text-gray-400 hover:text-primary-900 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">Completed</button>
                    </div>
                </div>

                @if($bookings->isEmpty())
                    <div class="text-center py-32">
                        <div class="bg-gray-50 text-gray-300 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fa-solid fa-clipboard-list text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-primary-900 uppercase tracking-tight">No Orders Found</h3>
                        <p class="text-gray-400 mt-2 font-medium">When customers purchase your products, they will appear here.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50/50 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                    <th class="px-8 py-6">Customer Profile</th>
                                    <th class="px-6 py-6">Product Details</th>
                                    <th class="px-6 py-6">Timeline</th>
                                    <th class="px-6 py-6 text-center">Status</th>
                                    <th class="px-8 py-6 text-right">Fulfillment</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($bookings as $booking)
                                    <tr class="hover:bg-primary-50/30 transition-all group" x-data="{ showDetails: false }">
                                        <td class="px-8 py-8">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-xl border-2 border-white shadow-md overflow-hidden flex-shrink-0 mr-4 group-hover:scale-110 transition-transform">
                                                    <img src="{{ $booking->user ? $booking->user->getAvatarUrl() : 'https://ui-avatars.com/api/?name=' . urlencode($booking->customer_name ?? 'User') }}" class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <div class="font-black text-primary-900 uppercase text-xs tracking-tight">{{ $booking->customer_name ?? $booking->user->name }}</div>
                                                    <div class="text-[10px] text-gray-500 font-bold mt-0.5">{{ $booking->customer_email ?? $booking->user->email }}</div>
                                                    @if($booking->customer_phone)
                                                        <div class="text-[10px] text-primary-900 font-black mt-1 uppercase tracking-tighter"><i class="fa-solid fa-phone mr-1 opacity-50"></i> {{ $booking->customer_phone }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-8 max-w-xs">
                                            <div class="text-sm font-black text-primary-900 uppercase tracking-tighter mb-2 line-clamp-1 group-hover:text-secondary-600 transition-colors">{{ $booking->service->name }}</div>
                                            <div class="flex flex-wrap gap-1.5 mb-2">
                                                <div class="text-[9px] text-primary-900 font-black uppercase tracking-widest bg-primary-50 px-2 py-0.5 rounded border border-primary-100">
                                                    {{ $booking->booking_data['package_name'] ?? 'Standard' }}
                                                </div>
                                                @if(!empty($booking->booking_data['selected_addons']))
                                                    @foreach($booking->booking_data['selected_addons'] as $addon)
                                                        <div class="text-[9px] text-secondary-600 font-black uppercase tracking-widest bg-secondary-50 px-2 py-0.5 rounded border border-secondary-100">
                                                            + {{ $addon }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button @click="showDetails = true" class="text-[9px] text-primary-900 hover:text-secondary-600 font-black uppercase tracking-widest flex items-center gap-1 transition-all">
                                                Order Details <i class="fa-solid fa-arrow-right text-[8px] animate-pulse"></i>
                                            </button>
                                        </td>
                                        <td class="px-6 py-8">
                                            <div class="font-black text-primary-900 uppercase text-xs tracking-tighter">{{ $booking->booking_date->format('d M, Y') }}</div>
                                            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $booking->booking_date->format('h:i A') }}</div>
                                            @if($booking->guest_count)
                                                <div class="text-[10px] text-primary-900 font-black mt-2 uppercase tracking-widest bg-slate-100 w-fit px-2 py-0.5 rounded">
                                                    <i class="fa-solid fa-layer-group mr-1 opacity-50"></i> QTY: {{ $booking->guest_count }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-8 text-center">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                    'confirmed' => 'bg-primary-50 text-primary-900 border-primary-100',
                                                    'completed' => 'bg-green-50 text-green-700 border-green-100',
                                                    'cancelled' => 'bg-secondary-50 text-secondary-600 border-secondary-100',
                                                ];
                                                $class = $statusClasses[$booking->status] ?? $statusClasses['pending'];
                                            @endphp
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $class }} border shadow-sm">
                                                {{ $booking->status }}
                                            </span>

                                            <div class="mt-3">
                                                @if($booking->payment && $booking->payment->status === 'completed')
                                                    <span class="text-[9px] font-black uppercase tracking-[0.1em] text-green-700 bg-green-50 px-3 py-1 rounded-lg border border-green-200"><i class="fa-solid fa-shield-check mr-1"></i> Payment Success</span>
                                                @else
                                                    <span class="text-[9px] font-black uppercase tracking-[0.1em] text-gray-400 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100"><i class="fa-solid fa-clock-rotate-left mr-1"></i> Awaiting Funds</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-8 py-8 text-right">
                                            <div class="flex justify-end gap-2">
                                                @if($booking->user_id)
                                                    <a href="{{ route('messages.index', $booking->user_id) }}" class="w-10 h-10 bg-white hover:bg-primary-900 hover:text-white text-primary-900 rounded-xl shadow-lg shadow-blue-900/5 border border-gray-100 flex items-center justify-center transition-all" title="Message Customer">
                                                        <i class="fa-solid fa-comment-dots text-xs"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('bookings.invoice', $booking) }}" class="w-10 h-10 bg-white hover:bg-primary-900 hover:text-white text-primary-900 rounded-xl shadow-lg shadow-blue-900/5 border border-gray-100 flex items-center justify-center transition-all" title="Invoice">
                                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                                </a>
                                                @if($booking->status === 'pending')
                                                    <form action="{{ route('vendor.orders.update', $booking->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="w-10 h-10 bg-primary-900 hover:bg-secondary-600 text-white rounded-xl shadow-lg shadow-blue-900/10 flex items-center justify-center transition-all" title="Accept">
                                                            <i class="fa-solid fa-check text-xs"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('vendor.orders.update', $booking->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="w-10 h-10 bg-white hover:bg-secondary-600 hover:text-white text-secondary-600 rounded-xl shadow-lg shadow-red-900/5 border border-secondary-100 flex items-center justify-center transition-all" title="Reject">
                                                            <i class="fa-solid fa-times text-xs"></i>
                                                        </button>
                                                    </form>
                                                @elseif($booking->status === 'confirmed')
                                                    <form action="{{ route('vendor.orders.update', $booking->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="bg-primary-900 hover:bg-secondary-600 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-900/10 transition-all transform hover:-translate-y-0.5">
                                                            Confirm Fulfillment
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Detail Modal -->
                                        <template x-teleport="body">
                                            <div x-show="showDetails" 
                                                 class="fixed inset-0 z-[100] overflow-y-auto" 
                                                 aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
                                                <div class="flex items-center justify-center min-h-screen px-4 py-12 text-center sm:p-0">
                                                    <div x-show="showDetails" 
                                                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                         class="fixed inset-0 bg-primary-900/40 backdrop-blur-sm transition-opacity" @click="showDetails = false" aria-hidden="true"></div>

                                                    <div x-show="showDetails" 
                                                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         class="inline-block align-middle bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-white/20">
                                                        
                                                        <div class="bg-primary-900 px-8 py-6 flex justify-between items-center relative overflow-hidden">
                                                            <div class="absolute inset-0 bg-gradient-to-r from-primary-900 via-primary-800 to-secondary-600 opacity-90"></div>
                                                            <h3 class="text-lg font-black uppercase text-white tracking-widest relative z-10" id="modal-title">
                                                                Order Specification #{{ $booking->id }}
                                                            </h3>
                                                            <button @click="showDetails = false" class="text-white/70 hover:text-white transition-colors relative z-10">
                                                                <i class="fa-solid fa-xmark text-xl"></i>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="px-10 py-8 max-h-[75vh] overflow-y-auto scrollbar-hide">
                                                            <!-- Contact Section -->
                                                            <div class="mb-8">
                                                                <h4 class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-black mb-5 border-b border-gray-100 pb-2">Client Profile</h4>
                                                                <div class="grid grid-cols-2 gap-8">
                                                                    <div>
                                                                        <span class="block text-gray-400 text-[9px] uppercase font-bold tracking-widest mb-1">Full Name</span>
                                                                        <span class="font-black text-primary-900 uppercase text-xs">{{ $booking->customer_name }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-400 text-[9px] uppercase font-bold tracking-widest mb-1">Product</span>
                                                                        <span class="font-black text-secondary-600 uppercase text-xs">{{ $booking->service->name }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-400 text-[9px] uppercase font-bold tracking-widest mb-1">Direct Contact</span>
                                                                        <span class="font-black text-primary-900 text-xs">{{ $booking->customer_phone }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-400 text-[9px] uppercase font-bold tracking-widest mb-1">Digital Identity</span>
                                                                        <span class="font-black text-primary-900 text-xs">{{ $booking->customer_email }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Details Section -->
                                                            <div class="mb-8">
                                                                <h4 class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-black mb-5 border-b border-gray-100 pb-2">Technical Specs</h4>
                                                                <div class="grid grid-cols-2 gap-8">
                                                                    <div>
                                                                        <span class="block text-gray-400 text-[9px] uppercase font-bold tracking-widest mb-1">Classification</span>
                                                                        <span class="font-black text-primary-900 uppercase text-xs">{{ $booking->event_type ?? 'Standard Product' }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-400 text-[9px] uppercase font-bold tracking-widest mb-1">Order Quantity</span>
                                                                        <span class="font-black text-primary-900 text-xs">{{ $booking->guest_count }} Units</span>
                                                                    </div>
                                                                    <div class="col-span-2">
                                                                        <span class="block text-gray-400 text-[9px] uppercase font-bold tracking-widest mb-1">Delivery Protocol</span>
                                                                        <span class="font-black text-primary-900 uppercase text-xs">{{ $booking->event_location }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Extended Data Section -->
                                                            @if($booking->booking_data)
                                                            <div class="mb-8 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                                                                <h4 class="text-[10px] uppercase tracking-[0.2em] text-primary-900 font-black mb-4">Meta Data & Customizations</h4>
                                                                <div class="grid grid-cols-2 gap-y-5 gap-x-8">
                                                                    @foreach($booking->booking_data as $key => $value)
                                                                        @if(!is_array($value))
                                                                            <div>
                                                                                <span class="block text-gray-400 text-[8px] uppercase font-bold tracking-widest mb-1">{{ str_replace('_', ' ', $key) }}</span>
                                                                                <span class="text-primary-900 font-black uppercase text-[10px]">{{ $value }}</span>
                                                                            </div>
                                                                        @else
                                                                            <div class="col-span-2">
                                                                                <span class="block text-gray-400 text-[8px] uppercase font-bold tracking-widest mb-1">{{ str_replace('_', ' ', $key) }}</span>
                                                                                <div class="flex flex-wrap gap-2 mt-1">
                                                                                    @foreach($value as $item)
                                                                                        <span class="px-3 py-1 bg-white border border-slate-200 text-primary-900 text-[9px] font-black uppercase tracking-widest rounded-lg shadow-sm">{{ str_replace('_', ' ', $item) }}</span>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            @endif
                                                            
                                                            @if($booking->notes)
                                                            <div>
                                                                <span class="block text-gray-400 text-[9px] uppercase font-bold tracking-widest mb-2">Customer Directives</span>
                                                                <div class="bg-primary-50/30 p-4 rounded-xl text-primary-900 text-xs font-medium border border-primary-100 leading-relaxed italic">
                                                                    "{{ $booking->notes }}"
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>

                                                        <div class="bg-gray-50 px-10 py-6 flex justify-end items-center gap-3 border-t border-gray-100">
                                                            <button type="button" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-100 transition-all shadow-sm" @click="showDetails = false">
                                                                Dismiss
                                                            </button>
                                                            @if($booking->status === 'pending')
                                                                <form action="{{ route('vendor.orders.update', $booking->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="confirmed">
                                                                    <button type="submit" class="px-6 py-2.5 bg-primary-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-secondary-600 transition-all shadow-lg shadow-blue-900/10">
                                                                        Approve Asset Sale
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


