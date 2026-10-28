@php
    $recentOrders = \App\Models\Booking::with(['service', 'user'])->latest()->take(5)->get();
@endphp

<div class="bg-white border border-emerald-100 rounded-[2.5rem] p-8 shadow-sm shadow-emerald-900/5">
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-ping"></span>
                <h3 class="text-emerald-950 font-black text-lg uppercase tracking-tighter">Live Store Orders</h3>
            </div>
            <p class="text-emerald-500 text-[10px] font-bold uppercase tracking-widest mt-1">Real-time incoming customer orders</p>
        </div>
        <a href="{{ route('admin.bookings') }}" class="text-[10px] font-black text-emerald-700 hover:text-emerald-900 uppercase tracking-widest bg-emerald-50 px-4 py-2 rounded-xl border border-emerald-100 transition-all flex items-center gap-2">
            View All Orders <i class="fa-solid fa-arrow-right text-[8px]"></i>
        </a>
    </div>

    @if($recentOrders->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-emerald-50/60 text-[9px] font-black text-emerald-800 uppercase tracking-widest border-b border-emerald-100/60">
                    <th class="px-4 py-3 rounded-l-xl">Customer</th>
                    <th class="px-4 py-3">Product Item</th>
                    <th class="px-4 py-3 text-center">Amount</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right rounded-r-xl">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($recentOrders as $order)
                <tr class="hover:bg-emerald-50/30 transition-colors">
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-emerald-100 text-emerald-900 font-black rounded-xl flex items-center justify-center text-xs shadow-sm">
                                {{ substr($order->customer_name ?? ($order->user->name ?? 'G'), 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-900 leading-tight">{{ $order->customer_name ?? ($order->user->name ?? 'Guest Customer') }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">{{ $order->customer_phone ?? ($order->customer_email ?? '') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-xs font-black text-slate-800 line-clamp-1 uppercase">{{ $order->service->name ?? 'Herbal Product' }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $order->created_at->diffForHumans() }}</p>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <span class="text-xs font-black text-emerald-800">Rs. {{ number_format($order->total_price ?? ($order->service->price ?? 0)) }}</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($order->status === 'pending')
                            <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider">Pending</span>
                        @elseif($order->status === 'confirmed')
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider">Processing</span>
                        @elseif($order->status === 'completed')
                            <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider">Delivered</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('bookings.invoice', $order) }}" target="_blank" class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-center hover:bg-emerald-700 hover:text-white transition-all shadow-sm" title="Print Invoice">
                                <i class="fa-solid fa-file-pdf text-xs"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
        <i class="fa-solid fa-box-open text-slate-300 text-3xl mb-2"></i>
        <p class="text-slate-400 font-bold text-xs">No orders placed yet.</p>
    </div>
    @endif
</div>
