<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <!-- Platform Revenue Card -->
    <div class="bg-white border border-emerald-100 border-t-4 border-t-emerald-600 p-8 rounded-[2rem] relative overflow-hidden group hover:border-emerald-200 transition-all duration-300 shadow-lg shadow-emerald-900/5 hover:shadow-xl hover:shadow-emerald-500/10">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-60"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-600/30 transform group-hover:-translate-y-1 transition-transform">
                    <i class="fa-solid fa-money-bill-trend-up text-white text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg uppercase tracking-[0.15em] shadow-sm">Gross Revenue</span>
            </div>
            <p class="text-4xl font-black text-emerald-950 tracking-tight mb-2">
                Rs. {{ number_format($totalPlatformRevenue ?? 0) }}
            </p>
            <p class="text-emerald-600/70 text-[11px] font-bold uppercase tracking-[0.15em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aggregate Store Revenue
            </p>
        </div>
    </div>

    <!-- Net Surplus Card -->
    <div class="bg-white border border-amber-100 border-t-4 border-t-amber-500 p-8 rounded-[2rem] relative overflow-hidden group hover:border-amber-200 transition-all duration-300 shadow-lg shadow-amber-900/5 hover:shadow-xl hover:shadow-amber-500/10">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-60"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-700 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/30 transform group-hover:-translate-y-1 transition-transform">
                    <i class="fa-solid fa-chart-line text-white text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-amber-700 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-lg uppercase tracking-[0.15em] shadow-sm">Net Yield</span>
            </div>
            <p class="text-4xl font-black text-emerald-950 tracking-tight mb-2">
                Rs. {{ number_format($totalCommissionEarned ?? 0) }}
            </p>
            <p class="text-amber-600/70 text-[11px] font-bold uppercase tracking-[0.15em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Consolidated Profit
            </p>
        </div>
    </div>

    <!-- Inventory Flow -->
    <div class="bg-white border border-emerald-100 border-t-4 border-t-emerald-400 p-8 rounded-[2rem] relative overflow-hidden group hover:border-emerald-200 transition-all duration-300 shadow-lg shadow-emerald-900/5 hover:shadow-xl hover:shadow-emerald-400/10">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-gradient-to-br from-emerald-50 to-green-100/50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-60"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-400/30 transform group-hover:-translate-y-1 transition-transform">
                    <i class="fa-solid fa-boxes-stacked text-white text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg uppercase tracking-[0.15em] shadow-sm">Inventory</span>
            </div>
            <p class="text-4xl font-black text-emerald-950 tracking-tight mb-2">
                {{ \App\Models\Service::count() }}
            </p>
            <p class="text-emerald-600/70 text-[11px] font-bold uppercase tracking-[0.15em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Total Herbal Products
            </p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- User Distribution -->
    <div class="bg-white border border-emerald-100 border-l-4 border-l-emerald-600 p-5 rounded-[1.5rem] hover:border-emerald-200 transition-all shadow-md shadow-emerald-900/5 hover:shadow-lg hover:shadow-emerald-500/10 group flex items-center gap-5">
        <div class="w-14 h-14 bg-emerald-50 text-emerald-700 rounded-2xl flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors duration-300 shadow-inner shrink-0">
            <i class="fa-solid fa-users text-lg"></i>
        </div>
        <div>
            <p class="text-emerald-600/70 text-[10px] font-black uppercase tracking-[0.15em] mb-0.5">Total Accounts</p>
            <p class="text-2xl font-black text-emerald-950 tracking-tight leading-none">{{ $users->count() }}</p>
        </div>
    </div>

    <!-- Store Verification Stats -->
    <div class="bg-white border border-amber-100 border-l-4 border-l-amber-500 p-5 rounded-[1.5rem] hover:border-amber-200 transition-all shadow-md shadow-amber-900/5 hover:shadow-lg hover:shadow-amber-500/10 group flex items-center gap-5">
        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300 shadow-inner shrink-0">
            <i class="fa-solid fa-store text-lg"></i>
        </div>
        <div>
            <p class="text-amber-600/70 text-[10px] font-black uppercase tracking-[0.15em] mb-0.5">Retail Stores</p>
            <p class="text-2xl font-black text-emerald-950 tracking-tight leading-none">{{ $users->where('role', 'vendor')->count() }}</p>
        </div>
    </div>

    <!-- Pending License -->
    <div class="bg-white border border-emerald-100 border-l-4 border-l-emerald-400 p-5 rounded-[1.5rem] hover:border-emerald-200 transition-all shadow-md shadow-emerald-900/5 hover:shadow-lg hover:shadow-emerald-400/10 group flex items-center gap-5">
        <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300 shadow-inner shrink-0">
            <i class="fa-solid fa-user-clock text-lg"></i>
        </div>
        <div>
            <p class="text-emerald-600/70 text-[10px] font-black uppercase tracking-[0.15em] mb-0.5">Pending License</p>
            <p class="text-2xl font-black text-emerald-950 tracking-tight leading-none">{{ $users->where('role', 'vendor')->where('is_verified', false)->count() }}</p>
        </div>
    </div>

    <!-- Support Tickets -->
    <div class="bg-white border border-amber-100 border-l-4 border-l-amber-400 p-5 rounded-[1.5rem] hover:border-amber-200 transition-all shadow-md shadow-amber-900/5 hover:shadow-lg hover:shadow-amber-400/10 group flex items-center gap-5">
        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300 shadow-inner shrink-0">
            <i class="fa-solid fa-headset text-lg"></i>
        </div>
        <div>
            <p class="text-amber-600/70 text-[10px] font-black uppercase tracking-[0.15em] mb-0.5">Support Tickets</p>
            <p class="text-2xl font-black text-emerald-950 tracking-tight leading-none">{{ $serviceDeskPendingCount ?? 0 }}</p>
        </div>
    </div>
</div>
