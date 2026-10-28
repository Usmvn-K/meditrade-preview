<x-app-layout>
    <div class="min-h-screen bg-gray-50 text-gray-900 py-10">
        <div class="max-w-7xl mx-auto px-6 sm:px-10">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Financial Report</h2>
                    <p class="text-gray-500 text-sm mt-1">Store sales performance, cost margins, and profitability overview</p>
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

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-6">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-2">Total Gross Sales</p>
                    <h3 class="text-3xl font-black text-gray-900">PKR {{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-6">
                    <p class="text-amber-500 text-xs font-bold uppercase tracking-widest mb-2">Cost of Goods Sold (60% Est.)</p>
                    <h3 class="text-3xl font-black text-amber-600">PKR {{ number_format($totalCOGS, 2) }}</h3>
                </div>
                <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-6">
                    <p class="text-emerald-500 text-xs font-bold uppercase tracking-widest mb-2">Estimated Net Profit (32% Est.)</p>
                    <h3 class="text-3xl font-black text-emerald-600">PKR {{ number_format($totalNetProfit, 2) }}</h3>
                </div>
            </div>

            <!-- Monthly Table -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-[2.5rem] p-8 overflow-hidden">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Monthly Breakdown</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Month</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Gross Sales</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Cost of Goods Sold (Est.)</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Estimated Net Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyRevenue as $row)
                            <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 text-sm font-bold text-gray-900">{{ $row->month }}</td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-700 text-right">PKR {{ number_format($row->total_sales, 2) }}</td>
                                <td class="py-4 px-6 text-sm font-medium text-amber-600 text-right">PKR {{ number_format($row->total_cogs, 2) }}</td>
                                <td class="py-4 px-6 text-sm font-black text-emerald-600 text-right">PKR {{ number_format($row->total_profit, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500 text-sm">No data available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
