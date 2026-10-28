<x-app-layout>
    <div class="min-h-screen bg-gray-50 text-gray-900 py-10">
        <div class="max-w-7xl mx-auto px-6 sm:px-10">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Sales by Product Category</h2>
                    <p class="text-gray-500 text-sm mt-1">Revenue distribution across product categories</p>
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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Data Table -->
                <div class="lg:col-span-8 bg-white border border-gray-100 shadow-sm rounded-[2.5rem] p-8 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100 bg-gray-50/50">
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest rounded-tl-xl">Product Category</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Products</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Orders</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-right rounded-tr-xl">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categorySales as $cat)
                                <tr class="border-b border-gray-50 last:border-0 hover:bg-amber-50/30 transition-colors">
                                    <td class="py-4 px-6 font-bold text-gray-900">{{ $cat['name'] }}</td>
                                    <td class="py-4 px-6 text-center text-sm font-medium text-gray-600">{{ $cat['total_services'] }}</td>
                                    <td class="py-4 px-6 text-center text-sm font-bold text-gray-700">
                                        <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $cat['total_bookings'] }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-right text-sm font-black text-amber-600">PKR {{ number_format($cat['total_sales'], 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500 text-sm">No category data available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Insights -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-gradient-to-br from-amber-50 to-white border border-amber-100 shadow-sm rounded-3xl p-6">
                        <h3 class="text-amber-900 font-black text-lg uppercase tracking-tighter mb-2">Top Category</h3>
                        <p class="text-sm text-gray-600 mb-4">Your most lucrative product category.</p>
                        @if(count($categorySales) > 0)
                            <div class="text-3xl font-black text-amber-600 mb-1">{{ $categorySales->first()['name'] }}</div>
                            <div class="text-sm font-bold text-gray-500 uppercase tracking-widest">PKR {{ number_format($categorySales->first()['total_sales'], 2) }}</div>
                        @else
                            <div class="text-gray-400 italic">No data</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
