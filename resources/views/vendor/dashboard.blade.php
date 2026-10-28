<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-primary-900 leading-tight uppercase tracking-tighter">
                    {{ __('Retail Command Center') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Welcome back, {{ Auth::user()->name }}! Monitoring store performance.</p>
            </div>
            <div class="flex gap-3">
                @if(Auth::user()->is_verified)
                    <a href="{{ route('vendor.orders') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                        <i class="fa-solid fa-clipboard-list text-primary-900"></i> Fulfillment Hub
                    </a>
                    <a href="{{ route('vendor.create-service') }}" class="bg-primary-900 hover:bg-secondary-600 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-plus"></i> List Asset
                    </a>
                @else
                    <div class="flex items-center gap-2 bg-yellow-50 text-yellow-700 px-4 py-2 rounded-xl border border-yellow-200">
                        <i class="fa-solid fa-clock"></i>
                        <span class="font-medium text-sm">Security Review</span>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(!Auth::user()->is_verified)
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 p-6 mb-8 rounded-2xl shadow-sm animate-pulse">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fa-solid fa-shield-halved text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-yellow-800 text-lg uppercase tracking-tight">Account Verification Underway</h4>
                            <p class="text-yellow-700 mt-1">Your retail license is currently being verified by our compliance team. Full ecosystem access granted post-verification.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Grid -->
            <div>
                @include('vendor.partials.dashboard-stats')
            </div>

            <!-- Charts Section -->
            <div class="grid lg:grid-cols-3 gap-8 mb-8 mt-8">
                <!-- Revenue Chart -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-primary-900 uppercase tracking-tighter">Gross Liquidity Analytics</h3>
                            <p class="text-xs text-gray-500">6-month revenue & acquisition trend</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-secondary-600"></span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Revenue (PKR)</span>
                        </div>
                    </div>
                    <div class="h-[300px] w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Order Volume -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-primary-900 uppercase tracking-tighter">Transaction Volume</h3>
                            <p class="text-xs text-gray-500">Monthly fulfillment counts</p>
                        </div>
                    </div>
                    <div class="h-[300px] w-full">
                        <canvas id="bookingsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-primary-900 flex items-center gap-2 uppercase tracking-tighter">
                            <i class="fa-solid fa-boxes-stacked text-secondary-600"></i> Active Inventory
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">Manage and track your premium products</p>
                    </div>
                    <span class="bg-primary-50 text-primary-900 px-4 py-2 rounded-full text-sm font-bold">{{ $services->count() }} {{ Str::plural('Product', $services->count()) }}</span>
                </div>

                @if($services->isEmpty())
                    <div class="p-16 text-center">
                        <div class="w-24 h-24 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                            <i class="fa-solid fa-box-open text-primary-900 text-4xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-primary-900 mb-2 uppercase tracking-tighter">No Products Detected</h4>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">Initialize your store by listing your first high-performance retail product.</p>
                        @if(Auth::user()->is_verified)
                            <a href="{{ route('vendor.create-service') }}" class="inline-flex items-center gap-2 bg-primary-900 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:bg-secondary-600 transition-all transform hover:-translate-y-0.5">
                                <i class="fa-solid fa-plus"></i> Deploy First Asset
                            </a>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @foreach($services as $service)
                            <div class="group bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:border-primary-100 transition-all duration-500 transform hover:-translate-y-1">
                                <div class="h-48 overflow-hidden relative">
                                    @php $featuredImage = $service->getFeaturedImage(); @endphp
                                    @if($featuredImage)
                                        <img src="{{ mediaUrl($featuredImage) }}" alt="{{ $service->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full bg-primary-900 flex items-center justify-center">
                                            <i class="fa-regular fa-image text-white text-3xl opacity-50"></i>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="absolute bottom-3 left-3 right-3 flex justify-between items-end opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                                        <span class="bg-white/90 backdrop-blur-sm text-primary-900 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">
                                            {{ $service->bookings()->count() }} Sales
                                        </span>
                                        <a href="{{ route('services.show', $service) }}" class="bg-white/90 backdrop-blur-sm text-primary-900 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-primary-900 hover:text-white transition-colors">
                                            <i class="fa-solid fa-eye mr-1"></i> Preview
                                        </a>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h4 class="font-black text-lg text-primary-900 mb-2 group-hover:text-secondary-600 transition-colors line-clamp-1 uppercase tracking-tighter">{{ $service->name }}</h4>
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">{{ $service->description }}</p>
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                        <span class="text-xl font-black text-primary-900">Rs. {{ number_format($service->price, 0) }}</span>
                                        <div class="flex gap-2">
                                            <a href="{{ route('vendor.edit-service', $service) }}" class="w-9 h-9 bg-gray-50 hover:bg-primary-900 hover:text-white text-gray-400 rounded-lg flex items-center justify-center transition-all shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </a>
                                            <form action="{{ route('vendor.destroy-service', $service) }}" method="POST" onsubmit="return confirm('Delete this asset?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-9 h-9 bg-gray-50 hover:bg-secondary-600 hover:text-white text-gray-400 rounded-lg flex items-center justify-center transition-all shadow-sm" title="Delete">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            
            // Revenue Chart
            const revCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revCtx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Gross Revenue',
                        data: chartData.revenue,
                        borderColor: '#172554',
                        backgroundColor: 'rgba(23, 37, 84, 0.05)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#172554',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: {
                                font: { size: 10, weight: '700' },
                                color: '#64748b',
                                callback: function(value) { return 'Rs ' + value.toLocaleString(); }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '700' }, color: '#64748b' }
                        }
                    }
                }
            });

            // Orders Chart
            const bookCtx = document.getElementById('bookingsChart').getContext('2d');
            const bookingsChart = new Chart(bookCtx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Retail Transactions',
                        data: chartData.bookings,
                        backgroundColor: '#dc2626',
                        borderRadius: 6,
                        barThickness: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: { font: { size: 10, weight: '700' }, color: '#64748b' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '700' }, color: '#64748b' }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>


