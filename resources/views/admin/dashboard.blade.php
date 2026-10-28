<x-app-layout>
    <div class="min-h-screen text-gray-900" style="background-color: #f0fdf4;">
        <!-- Sticky Header -->
        <div class="sticky top-0 z-30 border-b border-emerald-100/80 py-4 px-6 sm:px-10"
             style="background: rgba(255,255,255,0.85); backdrop-filter: blur(16px);">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-tr from-emerald-700 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <i class="fa-solid fa-leaf text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-xl text-emerald-950 leading-tight uppercase tracking-tighter">
                            {{ \App\Models\Setting::getValue('admin_dashboard_title', 'Herbal Control') }}
                        </h2>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            <p class="text-emerald-600 text-[10px] font-black uppercase tracking-[0.2em]">System Operational • {{ \App\Models\Setting::getValue('site_name', 'Gohar Herbal Care') }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.services') }}" class="hidden sm:flex items-center gap-2 bg-white hover:bg-emerald-50 text-emerald-700 px-5 py-2.5 rounded-xl transition-all border border-emerald-100 shadow-sm group">
                        <i class="fa-solid fa-boxes-stacked text-emerald-500 group-hover:scale-110 transition-transform"></i>
                        <span class="font-black text-[10px] uppercase tracking-widest">Inventory</span>
                    </a>
                    <div class="h-10 w-[1px] bg-emerald-100 mx-1"></div>
                    <a href="{{ route('home') }}" target="_blank" class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-500 hover:text-emerald-900 shadow-sm transition-colors">
                        <i class="fa-solid fa-seedling text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="py-10">
            <div class="max-w-7xl mx-auto px-6 sm:px-10">
                
                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl mb-10 flex items-center animate-fade-in">
                        <i class="fa-solid fa-circle-check mr-3 text-emerald-500"></i>
                        <span class="font-bold text-sm tracking-wide">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Stats Bento Grid -->
                <div x-data="{
                    refreshStats() {
                        fetch('{{ route('admin.dashboard') }}', { 
                            method: 'GET',
                            headers: { 'X-Partial': 'stats', 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.text())
                        .then(html => {
                            if($refs.statsContainer) $refs.statsContainer.innerHTML = html;
                        });
                    },
                    init() {
                        setInterval(() => this.refreshStats(), 15000);
                    }
                }" x-init="init()">
                    <div x-ref="statsContainer" class="animate-slide-up">
                        @include('admin.partials.dashboard-stats')
                    </div>
                </div>

                <!-- Main Grid Content -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-10">
                    
                    <!-- Left Column: Tables -->
                    <div class="lg:col-span-8 space-y-8">
                        
                        <!-- Recent Customers Section -->
                        <div x-data="{
                            refreshClients() {
                                fetch('{{ route('admin.dashboard') }}', { 
                                    method: 'GET',
                                    headers: { 'X-Partial': 'clients', 'X-Requested-With': 'XMLHttpRequest' }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    if($refs.clientsContainer) $refs.clientsContainer.innerHTML = html;
                                });
                            },
                            init() {
                                setInterval(() => this.refreshClients(), 20000);
                            }
                        }" x-init="init()">
                            <div class="bg-white border border-emerald-100 rounded-[2.5rem] p-8 shadow-sm shadow-emerald-900/5">
                                <div class="flex items-center justify-between mb-8">
                                    <div>
                                        <h3 class="text-emerald-950 font-black text-lg uppercase tracking-tighter">Recent Clients</h3>
                                        <p class="text-emerald-500 text-[10px] uppercase tracking-widest mt-1">Live customer registration feed</p>
                                    </div>
                                    <button @click="refreshClients()" class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-500 hover:text-emerald-900 hover:bg-emerald-100 transition-all">
                                        <i class="fa-solid fa-rotate text-xs"></i>
                                    </button>
                                </div>
                                <div x-ref="clientsContainer">
                                    @include('admin.partials.recent-clients-table')
                                </div>
                            </div>
                        </div>

                        <!-- Live Store Orders Section -->
                        @include('admin.partials.recent-orders-widget')

                        <!-- Activity Feed / Pending Actions -->
                        <div x-data="{
                            refreshVendors() {
                                fetch('{{ route('admin.dashboard') }}', { 
                                    method: 'GET',
                                    headers: { 'X-Partial': 'vendors', 'X-Requested-With': 'XMLHttpRequest' }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    if($refs.vendorsContainer) $refs.vendorsContainer.innerHTML = html;
                                });
                            },
                            init() {
                                setInterval(() => this.refreshVendors(), 25000);
                            }
                        }" x-init="init()">
                            <div class="bg-white border border-emerald-100 rounded-[2.5rem] p-8 shadow-sm shadow-emerald-900/5">
                                <div class="flex items-center justify-between mb-8">
                                    <div>
                                        <h3 class="text-emerald-950 font-black text-lg uppercase tracking-tighter">Pending Approvals</h3>
                                        <p class="text-emerald-500 text-[10px] uppercase tracking-widest mt-1">Accounts awaiting manual audit</p>
                                    </div>
                                    <button @click="refreshVendors()" class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-500 hover:text-emerald-900 hover:bg-emerald-100 transition-all">
                                        <i class="fa-solid fa-rotate text-xs"></i>
                                    </button>
                                </div>
                                <div x-ref="vendorsContainer">
                                    @include('admin.partials.pending-vendors-table')
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Quick Actions & Intelligence -->
                    <div class="lg:col-span-4 space-y-8">
                        <!-- Quick Actions Bento -->
                        <div class="bg-gradient-to-br from-emerald-950 to-emerald-900 border border-emerald-800/50 rounded-[2.5rem] p-8 shadow-xl shadow-emerald-900/20 relative overflow-hidden">
                            <!-- Mesh overlay -->
                            <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
                            <h3 class="text-white font-black text-lg uppercase tracking-tighter mb-6 relative z-10">Core Actions</h3>
                            <div class="grid grid-cols-2 gap-3 relative z-10">
                                <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center justify-center bg-white/10 hover:bg-white/20 border border-white/10 shadow-sm rounded-2xl p-5 transition-all group">
                                    <div class="w-11 h-11 bg-emerald-700/50 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform group-hover:bg-amber-500/30">
                                        <i class="fa-solid fa-user-plus text-emerald-300 group-hover:text-amber-300 text-sm transition-colors"></i>
                                    </div>
                                    <span class="text-white font-bold text-[9px] uppercase tracking-widest text-center">New User</span>
                                </a>
                                <a href="{{ route('admin.services') }}" class="flex flex-col items-center justify-center bg-white/10 hover:bg-white/20 border border-white/10 shadow-sm rounded-2xl p-5 transition-all group">
                                    <div class="w-11 h-11 bg-emerald-700/50 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform group-hover:bg-amber-500/30">
                                        <i class="fa-solid fa-cart-plus text-emerald-300 group-hover:text-amber-300 text-sm transition-colors"></i>
                                    </div>
                                    <span class="text-white font-bold text-[9px] uppercase tracking-widest text-center">Add Product</span>
                                </a>
                                <a href="{{ route('admin.bookings') }}" class="flex flex-col items-center justify-center bg-white/10 hover:bg-white/20 border border-white/10 shadow-sm rounded-2xl p-5 transition-all group">
                                    <div class="w-11 h-11 bg-emerald-700/50 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform group-hover:bg-amber-500/30">
                                        <i class="fa-solid fa-receipt text-emerald-300 group-hover:text-amber-300 text-sm transition-colors"></i>
                                    </div>
                                    <span class="text-white font-bold text-[9px] uppercase tracking-widest text-center">All Orders</span>
                                </a>
                                <a href="{{ route('admin.withdrawals') }}" class="flex flex-col items-center justify-center bg-white/10 hover:bg-white/20 border border-white/10 shadow-sm rounded-2xl p-5 transition-all group">
                                    <div class="w-11 h-11 bg-emerald-700/50 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform group-hover:bg-amber-500/30">
                                        <i class="fa-solid fa-wallet text-emerald-300 group-hover:text-amber-300 text-sm transition-colors"></i>
                                    </div>
                                    <span class="text-white font-bold text-[9px] uppercase tracking-widest text-center">Payments</span>
                                </a>
                                <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center justify-center bg-white/10 hover:bg-white/20 border border-white/10 shadow-sm rounded-2xl p-5 transition-all group">
                                    <div class="w-11 h-11 bg-emerald-700/50 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform group-hover:bg-amber-500/30">
                                        <i class="fa-solid fa-chart-pie text-emerald-300 group-hover:text-amber-300 text-sm transition-colors"></i>
                                    </div>
                                    <span class="text-white font-bold text-[9px] uppercase tracking-widest text-center">Reports Hub</span>
                                </a>
                                <a href="{{ route('admin.chart-of-accounts') }}" class="flex flex-col items-center justify-center bg-white/10 hover:bg-white/20 border border-white/10 shadow-sm rounded-2xl p-5 transition-all group">
                                    <div class="w-11 h-11 bg-emerald-700/50 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform group-hover:bg-amber-500/30">
                                        <i class="fa-solid fa-network-wired text-emerald-300 group-hover:text-amber-300 text-sm transition-colors"></i>
                                    </div>
                                    <span class="text-white font-bold text-[9px] uppercase tracking-widest text-center">Accounts Tree</span>
                                </a>
                            </div>
                        </div>

                        <!-- Herbal Intelligence Feed -->
                        <div class="bg-white border border-emerald-100 shadow-sm rounded-[2.5rem] p-8 relative overflow-hidden group">
                            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl group-hover:bg-emerald-100 transition-all duration-1000"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center">
                                        <i class="fa-solid fa-seedling text-emerald-600 text-sm"></i>
                                    </div>
                                    <h3 class="text-emerald-950 font-black text-base uppercase tracking-tighter">Herbal Feed</h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex gap-3">
                                        <div class="w-2 h-2 mt-2 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(21,128,61,0.5)] shrink-0"></div>
                                        <p class="text-gray-600 text-xs leading-relaxed font-medium">Organic inventory optimized for peak herbal wellness season.</p>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="w-2 h-2 mt-2 bg-amber-500 rounded-full shadow-[0_0_8px_rgba(217,119,6,0.5)] shrink-0"></div>
                                        <p class="text-gray-600 text-xs leading-relaxed font-medium">High demand detected in botanical extracts & essential oils.</p>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="w-2 h-2 mt-2 bg-emerald-400 rounded-full shadow-[0_0_8px_rgba(134,239,172,0.5)] shrink-0"></div>
                                        <p class="text-gray-600 text-xs leading-relaxed font-medium">Customer satisfaction index at all-time high of 98.4%.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
