<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Order: {{ $order->order_number }}</h2>
                <a href="{{ route('admin.app_orders.index') }}" class="text-gray-500 hover:text-gray-700">
                    &larr; Back to Orders
                </a>
            </div>

            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column (Order Items & Status Update) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Update Status Card -->
                    <div class="bg-white shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Update Order Status</h3>
                        
                        <form action="{{ route('admin.app_orders.updateStatus', $order) }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end">
                            @csrf
                            @method('PATCH')
                            
                            <div class="flex-1 w-full">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                                <select name="status" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="flex-1 w-full">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                                <select name="payment_status" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200">
                                    <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-bold py-2.5 px-6 rounded-lg shadow transition-colors h-[42px]">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Items Card -->
                    <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Items Ordered</h3>
                        </div>
                        <div class="p-0">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Product Name</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Price</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Qty</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="text-sm text-gray-500">Rs {{ number_format($item->product_price, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="text-sm font-bold text-gray-900">{{ $item->quantity }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="text-sm font-bold text-primary-600">Rs {{ number_format($item->line_total, 2) }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Totals -->
                        <div class="bg-gray-50 p-6 border-t border-gray-200">
                            <div class="flex justify-between py-1">
                                <span class="text-sm text-gray-600">Subtotal:</span>
                                <span class="text-sm font-medium">Rs {{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-sm text-gray-600">Shipping Fee:</span>
                                <span class="text-sm font-medium">Rs {{ number_format($order->shipping_fee, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2 mt-2 border-t border-gray-200">
                                <span class="text-lg font-bold text-gray-900">Grand Total:</span>
                                <span class="text-xl font-black text-primary-600">Rs {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Customer Info) -->
                <div class="space-y-6">
                    <div class="bg-white shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Customer Info</h3>
                        
                        <div class="mb-4">
                            <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Account</span>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Shipping Details</span>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <div class="font-medium text-gray-900">{{ $order->shipping_name }}</div>
                                <div class="text-sm text-gray-600 mt-1"><i class="fa-solid fa-phone mr-1 text-gray-400"></i> {{ $order->shipping_phone }}</div>
                                <div class="text-sm text-gray-600 mt-2"><i class="fa-solid fa-location-dot mr-1 text-gray-400"></i> {{ $order->shipping_address }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ $order->shipping_city }}</div>
                            </div>
                        </div>
                        
                        @if($order->notes)
                        <div>
                            <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Order Notes</span>
                            <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-100 text-sm text-yellow-800">
                                {{ $order->notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="bg-white shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Order Meta</h3>
                        <div class="flex justify-between py-1">
                            <span class="text-sm text-gray-600">Date:</span>
                            <span class="text-sm font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-sm text-gray-600">Payment Method:</span>
                            <span class="text-sm font-medium uppercase">{{ $order->payment_method }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
