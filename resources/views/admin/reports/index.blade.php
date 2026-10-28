<x-app-layout>
    <div class="min-h-screen bg-gray-50 text-gray-900 py-10">
        <div class="max-w-7xl mx-auto px-6 sm:px-10">
            <div class="mb-10">
                <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Reports Hub</h2>
                <p class="text-gray-500 text-sm mt-1">Store intelligence and administrative financials</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Store Financial Report -->
                <a href="{{ route('admin.reports.financial') }}" class="block bg-white border border-gray-100 shadow-sm hover:shadow-md rounded-[2rem] p-8 transition-all group">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-line text-2xl text-emerald-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Store Financials & COGS</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">View overall store gross sales, cost of goods sold (COGS), and net store profit margins.</p>
                </a>

                <!-- Product Performance Report -->
                <a href="{{ route('admin.reports.vendor-performance') }}" class="block bg-white border border-gray-100 shadow-sm hover:shadow-md rounded-[2rem] p-8 transition-all group">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-boxes-stacked text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Product Performance</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Analyze individual product sales counts, gross revenues, and customer ratings.</p>
                </a>

                <!-- Sales by Category Report -->
                <a href="{{ route('admin.reports.sales-by-category') }}" class="block bg-white border border-gray-100 shadow-sm hover:shadow-md rounded-[2rem] p-8 transition-all group">
                    <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-layer-group text-2xl text-amber-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Sales by Category</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Discover which product categories generate the most revenue and engagement.</p>
                </a>

                <!-- Order Status Report -->
                <a href="{{ route('admin.reports.booking-status') }}" class="block bg-white border border-gray-100 shadow-sm hover:shadow-md rounded-[2rem] p-8 transition-all group">
                    <div class="w-14 h-14 bg-rose-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-pie text-2xl text-rose-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Order Status Analytics</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Breakdown of store orders by their current fulfillment status (completed, pending, cancelled).</p>
                </a>

                <!-- Chart of Accounts Interactive Tree -->
                <a href="{{ route('admin.chart-of-accounts') }}" class="block bg-white border border-gray-100 shadow-sm hover:shadow-md rounded-[2rem] p-8 transition-all group">
                    <div class="w-14 h-14 bg-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-network-wired text-2xl text-teal-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Chart of Accounts</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Interactive double-entry virtual ledger tree. Analyze assets, liabilities, revenues, and COGS expenses.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
