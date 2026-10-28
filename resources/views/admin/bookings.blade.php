<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-black text-2xl text-slate-900 leading-tight uppercase tracking-tight">
                    <i class="fa-solid fa-cart-flatbed text-emerald-700 mr-2"></i>{{ __('Order Management') }}
                </h2>
                <p class="text-slate-500 text-xs font-bold mt-1">Monitor, verify and fulfill customer store orders</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold py-2.5 px-5 rounded-xl transition-all text-xs uppercase tracking-widest flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#f8fafc] min-h-screen" x-data="{ activeOrder: null, showModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Total Orders</span>
                            <span class="text-3xl font-black text-slate-900 mt-1 block">{{ $bookings->total() }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-lg">
                            <i class="fa-solid fa-box-archive"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest block">Pending Orders</span>
                            <span class="text-3xl font-black text-slate-900 mt-1 block">{{ \App\Models\Booking::where('status','pending')->count() }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-black text-lg">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest block">Processing</span>
                            <span class="text-3xl font-black text-slate-900 mt-1 block">{{ \App\Models\Booking::where('status','confirmed')->count() }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-lg">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest block">Delivered</span>
                            <span class="text-3xl font-black text-slate-900 mt-1 block">{{ \App\Models\Booking::where('status','completed')->count() }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-lg">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Orders Table --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Customer Store Orders</h3>
                        <p class="text-slate-400 text-xs font-medium">Showing latest orders placed by customers</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-xs font-black text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="px-6 py-4">Customer Details</th>
                                <th class="px-6 py-4">Product Purchased</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($bookings as $booking)
                                @php
                                    $orderData = [
                                        'id' => $booking->id,
                                        'customer_name' => $booking->customer_name ?? ($booking->user->name ?? 'Guest Customer'),
                                        'customer_email' => $booking->customer_email ?? ($booking->user->email ?? 'N/A'),
                                        'customer_phone' => $booking->customer_phone ?? 'N/A',
                                        'address' => $booking->event_location ?? 'Standard Delivery',
                                        'product_name' => $booking->service->name ?? 'Herbal Product',
                                        'price' => number_format($booking->total_price ?? ($booking->service->price ?? 0)),
                                        'quantity' => $booking->guest_count ?? 1,
                                        'date' => $booking->created_at->format('M d, Y h:i A'),
                                        'status' => $booking->status,
                                        'notes' => $booking->notes ?? 'No special instructions',
                                    ];
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-11 h-11 bg-emerald-100 text-emerald-900 rounded-2xl flex items-center justify-center font-black text-sm shadow-sm shrink-0">
                                                {{ substr($orderData['customer_name'], 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-900 text-sm leading-tight">{{ $orderData['customer_name'] }}</p>
                                                <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $orderData['customer_email'] }}</p>
                                                <p class="text-[10px] text-emerald-700 font-black mt-0.5"><i class="fa-solid fa-phone text-[9px] mr-1"></i>{{ $orderData['customer_phone'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="font-black text-slate-800 text-sm uppercase">{{ Str::limit($orderData['product_name'], 30) }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs font-black text-emerald-700">
                                                Rs. {{ $orderData['price'] }}
                                            </span>
                                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-bold">Qty: {{ $orderData['quantity'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="font-bold text-slate-800 text-xs">{{ $booking->created_at->format('M d, Y') }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium">{{ $booking->created_at->format('h:i A') }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($booking->status === 'pending')
                                            <span class="bg-amber-100 text-amber-800 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider">Pending</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider">Confirmed</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider">Delivered</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex justify-end gap-2 items-center">

                                            {{-- Details View Modal Trigger Button --}}
                                            <button @click="activeOrder = {{ json_encode($orderData) }}; showModal = true"
                                                    class="px-3 py-2 bg-emerald-50 hover:bg-emerald-700 text-emerald-700 hover:text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all border border-emerald-100 flex items-center gap-1.5 shadow-sm">
                                                <i class="fa-solid fa-eye"></i> Details
                                            </button>

                                            {{-- Printable PDF Invoice --}}
                                            <a href="{{ route('bookings.invoice', $booking) }}" target="_blank" class="w-9 h-9 bg-white hover:bg-slate-900 hover:text-white text-slate-700 rounded-xl shadow-sm border border-slate-200 flex items-center justify-center transition-all" title="Print Invoice">
                                                <i class="fa-solid fa-file-pdf text-xs"></i>
                                            </a>

                                            {{-- Status Action Forms --}}
                                            @if($booking->status === 'pending')
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="w-9 h-9 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl shadow-sm flex items-center justify-center transition-all" title="Confirm & Send Email">
                                                        <i class="fa-solid fa-check text-xs"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="w-9 h-9 bg-white hover:bg-red-600 hover:text-white text-red-600 rounded-xl shadow-sm border border-red-200 flex items-center justify-center transition-all" title="Cancel">
                                                        <i class="fa-solid fa-times text-xs"></i>
                                                    </button>
                                                </form>
                                            @elseif($booking->status === 'confirmed')
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white px-3 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                                                        Mark Complete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <i class="fa-solid fa-box-open text-slate-300 text-5xl mb-4 block"></i>
                                        <p class="text-slate-400 font-bold">No orders found yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($bookings->hasPages())
                    <div class="p-6 border-t border-slate-100">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ===== ORDER DETAILS MODAL ===== --}}
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4"
             x-cloak>
            
            <div @click.away="showModal = false"
                 class="bg-white rounded-[2.5rem] max-w-xl w-full p-8 shadow-2xl border border-slate-100 relative overflow-hidden">
                
                {{-- Header --}}
                <div class="flex items-center justify-between pb-6 border-b border-slate-100 mb-6">
                    <div>
                        <span class="text-[9px] font-black text-emerald-700 uppercase tracking-[0.3em] block">Gohar Mart Order Info</span>
                        <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Order Details</h3>
                    </div>
                    <button @click="showModal = false" class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-500 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-all">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                {{-- Content --}}
                <template x-if="activeOrder">
                    <div class="space-y-6">
                        {{-- Customer Box --}}
                        <div class="bg-emerald-50/60 p-6 rounded-2xl border border-emerald-100">
                            <h4 class="text-xs font-black text-emerald-900 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user"></i> Customer Information
                            </h4>
                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-slate-400 font-bold block uppercase text-[9px]">Full Name</span>
                                    <span class="font-black text-slate-900 text-sm" x-text="activeOrder.customer_name"></span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold block uppercase text-[9px]">Phone Number</span>
                                    <span class="font-black text-emerald-800" x-text="activeOrder.customer_phone"></span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-slate-400 font-bold block uppercase text-[9px]">Email Address</span>
                                    <span class="font-bold text-slate-700" x-text="activeOrder.customer_email"></span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-slate-400 font-bold block uppercase text-[9px]">Delivery Address</span>
                                    <span class="font-bold text-slate-800" x-text="activeOrder.address"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Product Box --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-box"></i> Order Items & Total
                            </h4>
                            <div class="flex justify-between items-center pb-3 border-b border-slate-200/60">
                                <div>
                                    <span class="font-black text-slate-900 text-base uppercase" x-text="activeOrder.product_name"></span>
                                    <span class="text-xs text-slate-400 font-bold block" x-text="'Quantity: ' + activeOrder.quantity"></span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-slate-400 font-bold block uppercase">Total Amount</span>
                                    <span class="text-xl font-black text-emerald-800" x-text="'PKR ' + activeOrder.price"></span>
                                </div>
                            </div>
                            <div class="pt-3 flex justify-between items-center text-xs">
                                <span class="text-slate-400 font-bold">Placed On: <span class="text-slate-700" x-text="activeOrder.date"></span></span>
                                <span class="font-black uppercase tracking-wider px-3 py-1 rounded-full text-[10px]"
                                      :class="activeOrder.status === 'confirmed' ? 'bg-blue-100 text-blue-800' : (activeOrder.status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800')"
                                      x-text="activeOrder.status"></span>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="bg-amber-50/50 p-4 rounded-2xl border border-amber-100 text-xs">
                            <span class="text-amber-800 font-black uppercase text-[9px] block mb-1">Order Notes / Instructions</span>
                            <p class="text-slate-600 font-medium" x-text="activeOrder.notes"></p>
                        </div>
                    </div>
                </template>

                {{-- Modal Footer --}}
                <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end">
                    <button @click="showModal = false" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-700 transition-colors">
                        Close Details
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
