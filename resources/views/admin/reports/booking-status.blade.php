<x-app-layout>
    <div class="min-h-screen bg-gray-50 text-gray-900 py-10">
        <div class="max-w-7xl mx-auto px-6 sm:px-10">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Order Status Analytics</h2>
                    <p class="text-gray-500 text-sm mt-1">Overview of store order lifecycles and fulfillment status</p>
                </div>
                <div class="flex gap-4">
                    <button onclick="window.print()" class="bg-gray-800 text-white px-5 py-2.5 rounded-xl hover:bg-gray-900 transition-colors shadow-sm font-bold text-xs uppercase tracking-widest">
                        <i class="fa-solid fa-print mr-2"></i> Print
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-colors shadow-sm font-bold text-xs uppercase tracking-widest">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-6">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-2">Total Orders</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $totalBookings }}</h3>
                </div>

                <!-- Status Cards -->
                @php
                    $statusColors = [
                        'pending' => 'amber',
                        'confirmed' => 'blue',
                        'completed' => 'emerald',
                        'cancelled' => 'rose',
                        'refunded' => 'gray',
                    ];
                @endphp

                @foreach($statuses as $status => $count)
                    @php
                        $color = $statusColors[$status] ?? 'indigo';
                        $percentage = $totalBookings > 0 ? round(($count / $totalBookings) * 100, 1) : 0;
                    @endphp
                    <div class="bg-white border border-{{ $color }}-100 shadow-sm rounded-3xl p-6 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-{{ $color }}-50 rounded-full"></div>
                        <p class="text-{{ $color }}-500 text-xs font-bold uppercase tracking-widest mb-2 relative z-10">{{ ucfirst($status) }}</p>
                        <div class="flex items-end gap-3 relative z-10">
                            <h3 class="text-3xl font-black text-gray-900">{{ $count }}</h3>
                            <p class="text-sm font-medium text-gray-500 mb-1">({{ $percentage }}%)</p>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mt-4">
                            <div class="bg-{{ $color }}-500 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
