<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-primary-900 leading-tight uppercase tracking-tighter">
                    <i class="fa-solid fa-chart-pie text-secondary-600 mr-2"></i>{{ __('Analytics & Earnings') }}
                </h2>
                <p class="text-gray-500 text-xs mt-1 font-black uppercase tracking-widest">Track your retail performance and growth</p>
            </div>
            <a href="{{ route('vendor.dashboard') }}" class="bg-white border border-gray-100 hover:bg-primary-900 hover:text-white text-primary-900 font-black uppercase text-xs tracking-widest py-3 px-6 rounded-xl transition-all flex items-center gap-2 shadow-sm hover:shadow-lg">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Earnings Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <!-- Total Earnings -->
                <div class="bg-primary-900 p-8 rounded-[2rem] text-white relative overflow-hidden shadow-2xl shadow-blue-900/20">
                    <div class="absolute right-0 top-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-wallet text-2xl text-white"></i>
                        </div>
                        <p class="text-blue-100/70 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Cumulative Revenue</p>
                        <p class="text-4xl font-black tracking-tighter">Rs. {{ number_format($totalEarnings) }}</p>
                        <p class="text-blue-100/50 text-[10px] font-black uppercase tracking-widest mt-3">Verified transactions only</p>
                    </div>
                </div>

                <!-- This Month -->
                <div class="bg-white p-8 rounded-[2rem] text-primary-900 relative overflow-hidden shadow-xl shadow-blue-900/5 border border-gray-100">
                    <div class="absolute right-0 top-0 w-40 h-40 bg-primary-50 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-primary-50 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-calendar-check text-2xl text-primary-900"></i>
                        </div>
                        <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Monthly Performance</p>
                        <p class="text-4xl font-black tracking-tighter text-secondary-600">Rs. {{ number_format($thisMonthEarnings) }}</p>
                        <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mt-3">{{ now()->format('F Y') }} Protocol</p>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-secondary-600 p-8 rounded-[2rem] text-white relative overflow-hidden shadow-2xl shadow-red-900/20">
                    <div class="absolute right-0 top-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-box-open text-2xl text-white"></i>
                        </div>
                        <p class="text-red-100/70 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Success Rate</p>
                        <p class="text-4xl font-black tracking-tighter">{{ $recentBookings->where('status', 'completed')->count() }}</p>
                        <p class="text-red-100/50 text-[10px] font-black uppercase tracking-widest mt-3">Completed fulfillments</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Top Products -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-100 bg-gray-50/30">
                        <h3 class="text-lg font-black text-primary-900 flex items-center gap-2 uppercase tracking-tighter">
                            <i class="fa-solid fa-trophy text-secondary-600"></i> Flagship Inventory
                        </h3>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mt-1">Ranked by transaction volume</p>
                    </div>
                    <div class="p-8">
                        @forelse($topServices as $index => $service)
                            <div class="flex items-center gap-5 {{ !$loop->last ? 'mb-6 pb-6 border-b border-gray-100' : '' }}">
                                <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-primary-900 font-black shadow-inner">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-black text-primary-900 uppercase text-xs tracking-tight">{{ $service->name }}</h4>
                                    <p class="text-[10px] text-gray-500 font-bold mt-1">UNIT PRICE: Rs. {{ number_format($service->price) }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="bg-primary-900 text-white px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-900/10">
                                        {{ $service->bookings_count }} Sales
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class="fa-solid fa-chart-line text-gray-200 text-5xl mb-4"></i>
                                <p class="text-gray-400 font-black uppercase text-[10px] tracking-widest">No transaction data available</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-100 bg-gray-50/30">
                        <h3 class="text-lg font-black text-primary-900 flex items-center gap-2 uppercase tracking-tighter">
                            <i class="fa-solid fa-bolt text-secondary-600"></i> Live Activity
                        </h3>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mt-1">Latest transaction updates</p>
                    </div>
                    <div class="p-8 max-h-[400px] overflow-y-auto scrollbar-hide">
                        @forelse($recentBookings as $booking)
                            <div class="flex items-start gap-5 {{ !$loop->last ? 'mb-6 pb-6 border-b border-gray-100' : '' }}">
                                <div class="w-12 h-12 bg-primary-50 border border-primary-100 rounded-2xl flex items-center justify-center text-primary-900 font-black flex-shrink-0 uppercase text-xs">
                                    {{ substr($booking->user->name, 0, 2) }}
                                </div>
                                <div class="flex-grow min-w-0">
                                    <p class="font-black text-primary-900 uppercase text-xs tracking-tight">{{ $booking->user->name }}</p>
                                    <p class="text-[10px] text-gray-500 font-bold mt-1 truncate">{{ $booking->service->name }}</p>
                                    <p class="text-[9px] text-gray-400 mt-2 font-black uppercase tracking-widest"><i class="fa-regular fa-clock mr-1"></i> {{ $booking->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'confirmed' => 'bg-primary-50 text-primary-900 border-primary-100',
                                            'completed' => 'bg-green-50 text-green-700 border-green-100',
                                            'cancelled' => 'bg-secondary-50 text-secondary-600 border-secondary-100',
                                        ];
                                        $style = $statusStyles[$booking->status] ?? $statusStyles['pending'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $style }}">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class="fa-solid fa-inbox text-gray-200 text-5xl mb-4"></i>
                                <p class="text-gray-400 font-black uppercase text-[10px] tracking-widest">No recent transactions</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="{{ route('vendor.orders') }}" class="group bg-white rounded-[2rem] p-8 border border-gray-100 hover:border-primary-900 hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center group-hover:bg-primary-900 transition-all shadow-inner">
                            <i class="fa-solid fa-clipboard-list text-primary-900 group-hover:text-white transition-all"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-primary-900 uppercase text-xs tracking-widest">Retail Orders</h4>
                            <p class="text-[10px] text-gray-500 font-bold mt-1 uppercase">Manage fulfillments</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('vendor.create-service') }}" class="group bg-white rounded-[2rem] p-8 border border-gray-100 hover:border-secondary-600 hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center group-hover:bg-secondary-600 transition-all shadow-inner">
                            <i class="fa-solid fa-plus text-primary-900 group-hover:text-white transition-all"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-primary-900 uppercase text-xs tracking-widest">Add Product</h4>
                            <p class="text-[10px] text-gray-500 font-bold mt-1 uppercase">Expand inventory</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('vendor.dashboard') }}" class="group bg-white rounded-[2rem] p-8 border border-gray-100 hover:border-primary-900 hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center group-hover:bg-primary-900 transition-all shadow-inner">
                            <i class="fa-solid fa-boxes-stacked text-primary-900 group-hover:text-white transition-all"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-primary-900 uppercase text-xs tracking-widest">Warehouse</h4>
                            <p class="text-[10px] text-gray-500 font-bold mt-1 uppercase">Manage listings</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>


