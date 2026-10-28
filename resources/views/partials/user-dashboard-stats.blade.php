<div class="space-y-6">
    <!-- Active Shipments Card -->
    <div class="bg-gradient-to-br from-primary-900 to-primary-700 p-8 rounded-[2.5rem] text-white shadow-xl shadow-primary-900/20 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <i class="fa-solid fa-truck-moving text-2xl opacity-50 group-hover:opacity-100 transition-opacity"></i>
                <span class="text-[9px] font-black uppercase tracking-widest bg-white/20 px-3 py-1 rounded-full">In Transit</span>
            </div>
            <p class="text-4xl font-black tracking-tighter mb-1">02</p>
            <p class="text-white/60 text-[10px] font-black uppercase tracking-widest">Active Deliveries</p>
        </div>
    </div>

    <!-- Total Expenditure Card -->
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-50 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Total Spend</span>
            </div>
            <p class="text-3xl font-black text-slate-900 tracking-tighter mb-1">Rs. {{ number_format(Auth::user()->bookings()->sum('total_price')) }}</p>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Aggregate Investment</p>
        </div>
    </div>

    <!-- Reward Points / Tier Card -->
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">Gold Tier</span>
            </div>
            <p class="text-3xl font-black text-slate-900 tracking-tighter mb-1">1,250</p>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Nexus Points Balance</p>
        </div>
    </div>
</div>
