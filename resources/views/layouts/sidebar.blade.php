<div class="fixed inset-y-0 left-0 z-50 w-64 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col"
     style="background: linear-gradient(180deg, #022c22 0%, #052e16 50%, #14532d 100%);"
     :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
    
    <!-- Logo Section -->
    <div class="flex items-center justify-center h-20 border-b border-emerald-800/50 relative shrink-0"
         style="background: rgba(5, 46, 22, 0.6); backdrop-filter: blur(8px);">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            @php $sidebarLogo = \App\Models\Setting::getValue('site_logo'); @endphp
            @if($sidebarLogo)
                <img src="{{ mediaUrl($sidebarLogo) }}" alt="{{ \App\Models\Setting::getValue('site_name', 'Gohar Herbal Care') }}" class="w-10 h-10 rounded-xl object-contain group-hover:scale-110 transition-transform">
            @else
                <div class="w-10 h-10 bg-gradient-to-tr from-emerald-600 to-amber-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-leaf text-white text-lg"></i>
                </div>
            @endif
            <div>
                <span class="font-black text-lg tracking-tighter text-white leading-none block">{{ \App\Models\Setting::getValue('site_name', 'Gohar Herbal') }}</span>
                <span class="text-[8px] font-black text-emerald-400 uppercase tracking-[0.2em]">Herbal Care Admin</span>
            </div>
        </a>
        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden absolute right-4 text-emerald-400 hover:text-white transition-colors">
            <i class="fa-solid fa-times text-xl"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="p-4 space-y-1 overflow-y-auto flex-1 custom-scrollbar">
        
        <div class="px-3 pb-2 pt-4">
            <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em]">Main Menu</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-chart-line text-sm"></i>
            </div>
            Dashboard
        </a>

        <a href="{{ route('admin.services') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.services') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.services') ? 'bg-emerald-500/20 text-emerald-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-boxes-stacked text-sm"></i>
            </div>
            Add Product
        </a>

        <!-- Shop Products → links to Services (real products) -->
        <a href="{{ route('admin.services') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.services') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.services') ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-box-open text-sm"></i>
            </div>
            Shop Products
        </a>

        <a href="{{ route('admin.service-categories.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.service-categories.*') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.service-categories.*') ? 'bg-emerald-500/20 text-emerald-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-list-check text-sm"></i>
            </div>
            Categories
        </a>

        <a href="{{ route('admin.sub-categories.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.sub-categories.*') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.sub-categories.*') ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-sitemap text-sm"></i>
            </div>
            Sub Categories
        </a>

        <a href="{{ route('admin.brands.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.brands.*') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.brands.*') ? 'bg-emerald-500/20 text-emerald-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-tag text-sm"></i>
            </div>
            Brands
        </a>

        <a href="{{ route('admin.units.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.units.*') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.units.*') ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-scale-balanced text-sm"></i>
            </div>
            Units of Measurement
        </a>

        <a href="{{ route('admin.bookings') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.bookings') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.bookings') ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-cart-flatbed text-sm"></i>
            </div>
            Order Management
        </a>

        <!-- New App Orders -->
        <a href="{{ route('admin.app_orders.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.app_orders.*') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.app_orders.*') ? 'bg-emerald-500/20 text-emerald-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-mobile-screen-button text-sm"></i>
            </div>
            App Mobile Orders
        </a>

        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.users.*') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.users.*') ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-users text-sm"></i>
            </div>
            User Management
        </a>
        
        <div class="px-3 pb-2 pt-5">
            <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em]">System</p>
        </div>

        <a href="{{ route('admin.reports.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.reports.*') || request()->routeIs('admin.chart-of-accounts') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.reports.*') || request()->routeIs('admin.chart-of-accounts') ? 'bg-emerald-500/20 text-emerald-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-chart-pie text-sm"></i>
            </div>
            Reports Hub
        </a>

        <a href="{{ route('admin.withdrawals') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.withdrawals') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.withdrawals') ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-wallet text-sm"></i>
            </div>
            Payments
        </a>

        <a href="{{ route('admin.settings') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 font-bold text-sm {{ request()->routeIs('admin.settings') ? 'bg-emerald-700/80 text-white border-l-4 border-amber-400 shadow-lg shadow-emerald-900/30' : 'text-emerald-200 hover:bg-emerald-800/40 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.settings') ? 'bg-emerald-500/20 text-emerald-300' : 'bg-emerald-800/40 text-emerald-400' }}">
                <i class="fa-solid fa-gear text-sm"></i>
            </div>
            Settings
        </a>

        <!-- Bottom user info -->
        <div class="mt-4 pt-4 border-t border-emerald-800/40">
            <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-emerald-900/30 border border-emerald-800/30">
                <img src="{{ Auth::user()->getAvatarUrl() }}" class="w-8 h-8 rounded-full object-cover border-2 border-emerald-600/50" alt="{{ Auth::user()->name }}">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-black text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest">Admin</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-7 h-7 rounded-lg bg-emerald-800/50 flex items-center justify-center text-emerald-400 hover:bg-amber-500/20 hover:text-amber-300 transition-all" title="Logout">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>

<!-- Backdrop for mobile -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-emerald-950/80 z-40 lg:hidden backdrop-blur-sm" x-cloak></div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(134,239,172,0.15); border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(134,239,172,0.3); }
</style>
