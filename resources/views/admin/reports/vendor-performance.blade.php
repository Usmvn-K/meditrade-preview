<x-app-layout>
    <div class="min-h-screen bg-gray-50 text-gray-900 py-10">
        <div class="max-w-7xl mx-auto px-6 sm:px-10">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Product Performance</h2>
                    <p class="text-gray-500 text-sm mt-1">Analytics for store products and sales velocity</p>
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

            <div class="bg-white border border-gray-100 shadow-sm rounded-[2.5rem] p-8 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100 bg-gray-50/50">
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest rounded-tl-xl">Product Name</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest">Category</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Orders Completed</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-right">Gross Revenue</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-center rounded-tr-xl">Avg Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr class="border-b border-gray-50 last:border-0 hover:bg-indigo-50/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        @if($product->image)
                                            <img src="{{ mediaUrl($product->image) }}" class="w-10 h-10 rounded-xl object-cover border border-gray-100" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold uppercase">
                                                {{ substr($product->name, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-400">ID: #{{ $product->id }} | PKR {{ number_format($product->getCurrentPrice(), 2) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-600">
                                    {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm font-bold text-gray-700">
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">{{ $product->total_orders ?? 0 }}</span>
                                </td>
                                <td class="py-4 px-6 text-right text-sm font-black text-indigo-600">
                                    PKR {{ number_format($product->total_sales ?? 0, 2) }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm font-bold text-amber-500">
                                    <div class="flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-star"></i>
                                        <span>{{ number_format($product->average_rating ?? 0, 1) }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500 text-sm">No products found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
