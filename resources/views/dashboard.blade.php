<x-app-layout>
    <div class="min-h-screen py-12" style="background-color: #f0fdf4;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Bento -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Profile Glass Card -->
                <div class="lg:col-span-2 bg-white rounded-[3rem] p-10 shadow-xl shadow-emerald-900/5 border border-emerald-100 relative overflow-hidden group">
                    <!-- Botanical blob -->
                    <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-1000"></div>
                    <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-amber-50 rounded-full opacity-50"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                        <div class="relative shrink-0">
                            <div class="w-32 h-32 rounded-[2.5rem] p-1 bg-gradient-to-tr from-emerald-700 to-emerald-500 shadow-2xl shadow-emerald-600/30">
                                <img src="{{ Auth::user()->getAvatarUrl() }}" class="w-full h-full object-cover rounded-[2.25rem] border-4 border-white" alt="{{ Auth::user()->name }}">
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-emerald-500 border-4 border-white rounded-2xl flex items-center justify-center text-white text-xs shadow-lg">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>
                        <div class="text-center md:text-left">
                            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.3em] mb-2">Welcome Back</p>
                            <h2 class="text-4xl font-black text-emerald-950 leading-none tracking-tighter">
                                {{ __('Hello') }}, <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-emerald-800">{{ Auth::user()->name }}</span>!
                            </h2>
                            <p class="text-emerald-700/60 mt-4 font-medium max-w-md leading-relaxed text-sm">
                                Welcome to your personalized herbal care portal. Manage your orders, track herbal deliveries, and explore our organic collections.
                            </p>
                            <div class="flex flex-wrap gap-4 mt-8 justify-center md:justify-start">
                                <a href="{{ route('home') }}" class="bg-emerald-700 hover:bg-emerald-800 text-white px-8 py-3.5 rounded-2xl font-black text-sm hover:shadow-lg hover:shadow-emerald-600/20 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                                    <i class="fa-solid fa-leaf"></i> Browse Store
                                </a>
                                <a href="{{ route('profile.edit') }}" class="bg-white border border-emerald-100 text-emerald-700 px-8 py-3.5 rounded-2xl font-black text-sm hover:bg-emerald-50 transition-all shadow-sm">
                                    Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid Bento -->
                <div x-data="{
                    refreshDashboardStats() {
                        fetch('{{ route('dashboard') }}', {
                            headers: { 'X-Partial': 'user-stats', 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.text())
                        .then(html => {
                            if($refs.userStatsContainer) $refs.userStatsContainer.innerHTML = html;
                        });
                    },
                    init() {
                        setInterval(() => this.refreshDashboardStats(), 15000);
                    }
                }" x-init="init()" class="space-y-6">
                    <div x-ref="userStatsContainer">
                        @include('partials.user-dashboard-stats')
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <a href="{{ route('bookings.index') }}" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-emerald-100 hover:shadow-xl hover:shadow-emerald-900/10 hover:border-emerald-200 transition-all group overflow-hidden relative">
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform opacity-80"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-700 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-700 group-hover:text-white transition-all transform group-hover:rotate-6 shadow-sm">
                            <i class="fa-solid fa-box-open text-xl"></i>
                        </div>
                        <h4 class="text-xl font-black text-emerald-950 tracking-tight mb-2">My Orders</h4>
                        <p class="text-emerald-600/60 text-sm font-medium">Track active deliveries & history</p>
                    </div>
                </a>

                <a href="{{ route('wishlist.index') }}" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-emerald-100 hover:shadow-xl hover:shadow-amber-900/10 hover:border-amber-100 transition-all group overflow-hidden relative">
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-amber-50 rounded-full group-hover:scale-150 transition-transform opacity-80"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-500 group-hover:text-white transition-all transform group-hover:-rotate-6 shadow-sm">
                            <i class="fa-solid fa-heart text-xl"></i>
                        </div>
                        <h4 class="text-xl font-black text-emerald-950 tracking-tight mb-2">Wishlist</h4>
                        <p class="text-emerald-600/60 text-sm font-medium">Saved herbal items for later</p>
                    </div>
                </a>

                <a href="{{ route('messages.index') }}" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-emerald-100 hover:shadow-xl hover:shadow-emerald-900/10 hover:border-emerald-200 transition-all group overflow-hidden relative">
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform opacity-80"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all transform group-hover:rotate-6 shadow-sm">
                            <i class="fa-solid fa-comment-dots text-xl"></i>
                        </div>
                        <h4 class="text-xl font-black text-emerald-950 tracking-tight mb-2">Support</h4>
                        <p class="text-emerald-600/60 text-sm font-medium">Live chat with our herbalists</p>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-emerald-100 hover:shadow-xl hover:shadow-emerald-900/10 hover:border-emerald-200 transition-all group overflow-hidden relative">
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform opacity-80"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-900 group-hover:text-white transition-all transform group-hover:-rotate-6 shadow-sm">
                            <i class="fa-solid fa-gear text-xl"></i>
                        </div>
                        <h4 class="text-xl font-black text-emerald-950 tracking-tight mb-2">Profile</h4>
                        <p class="text-emerald-600/60 text-sm font-medium">Security & personal info</p>
                    </div>
                </a>
            </div>

            <!-- Recent Activity / Order Timeline -->
            <div class="bg-white rounded-[3rem] p-10 shadow-xl shadow-emerald-900/5 border border-emerald-100">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h3 class="text-2xl font-black text-emerald-950 tracking-tight">Order Progression</h3>
                        <p class="text-emerald-500 text-xs mt-1 uppercase font-bold tracking-widest">Real-time herbal delivery updates</p>
                    </div>
                    <a href="{{ route('bookings.index') }}" class="text-emerald-700 font-black text-sm hover:text-emerald-900 flex items-center gap-2 hover:underline transition-colors">
                        View History <i class="fa-solid fa-arrow-right-long text-xs"></i>
                    </a>
                </div>
                
                <div class="bg-emerald-50 rounded-3xl p-8 border border-emerald-100 flex flex-col items-center justify-center text-center py-20">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-6 border border-emerald-100">
                        <i class="fa-solid fa-truck-fast text-emerald-500 text-2xl animate-pulse"></i>
                    </div>
                    <p class="text-emerald-600/60 font-medium italic text-sm">"Your active orders and herbal delivery timelines will appear here once initiated."</p>
                    <a href="{{ route('home') }}" class="mt-8 inline-flex items-center gap-2 bg-emerald-700 text-white font-black text-[10px] uppercase tracking-widest px-6 py-3 rounded-xl hover:bg-emerald-800 transition-all shadow-lg shadow-emerald-600/20 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-600/25">
                        <i class="fa-solid fa-leaf"></i> Start Shopping Now
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
