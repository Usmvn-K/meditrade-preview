@php
    $isAdmin = request()->routeIs('admin.*');
@endphp
<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-emerald-100/80" 
     style="background: rgba(255,255,255,0.92); backdrop-filter: blur(16px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[64px]">
            <div class="flex items-center">
                <!-- Hamburger for Sidebar (Mobile Only) -->
                @if(Auth::check() && Auth::user()->hasRole('admin'))
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden mr-4 p-2 rounded-xl text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 focus:outline-none transition">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                @endif
                
                <!-- Logo (Only for non-admin, as admin has it in sidebar) -->
                @if(!Auth::check() || !Auth::user()->hasRole('admin'))
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                            <div class="w-10 h-10 bg-gradient-to-tr from-emerald-700 to-emerald-500 rounded-xl flex items-center justify-center transform group-hover:-rotate-12 transition-all shadow-lg shadow-emerald-500/20">
                                <i class="fa-solid fa-leaf text-white text-lg"></i>
                            </div>
                            <span class="font-black text-xl text-emerald-900 tracking-tighter hidden sm:inline-block">
                                {{ \App\Models\Setting::getValue('site_name', 'Gohar Herbal') }}
                            </span>
                        </a>
                    </div>
                @endif

                <div class="hidden sm:flex sm:items-center ml-6">
                    <div class="bg-emerald-50 px-3 py-1.5 rounded-lg flex items-center gap-2 border border-emerald-100">
                        <i class="fa-regular fa-clock text-emerald-500 animate-pulse text-[10px]"></i>
                        <span id="nav-clock" class="text-xs font-black text-emerald-900 tabular-nums tracking-wider leading-none">--:--:--</span>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                @auth
                    <!-- Store Front Link -->
                    <a href="{{ route('home') }}" target="_blank" class="text-[10px] font-black uppercase tracking-widest text-emerald-600 hover:text-emerald-900 flex items-center gap-2 transition-colors px-3 py-1.5 rounded-lg hover:bg-emerald-50 border border-transparent hover:border-emerald-100">
                        <i class="fa-solid fa-seedling"></i> Store Front
                    </a>

                    <!-- Messaging Node -->
                    <div class="relative group" x-data="{ 
                        count: 0,
                        init() {
                            fetch('{{ route('messages.unread-count') }}')
                                .then(res => res.json())
                                .then(data => this.count = data.count);
                        }
                    }">
                        <a href="{{ route('messages.index') }}" class="w-10 h-10 rounded-xl border border-emerald-100 text-emerald-500 hover:text-emerald-900 hover:border-emerald-300 hover:bg-emerald-50 flex items-center justify-center transition-all">
                            <i class="fa-solid fa-message text-sm"></i>
                        </a>
                        <template x-if="count > 0">
                            <div class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-amber-500 rounded-full border-2 border-white flex items-center justify-center text-[8px] font-black text-white shadow-sm animate-pulse px-1" x-text="count"></div>
                        </template>
                    </div>

                    <!-- Notification Bell -->
                    @include('components.notification-bell')
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-emerald-100 text-sm leading-4 font-medium rounded-xl text-gray-600 bg-white hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 focus:outline-none transition ease-in-out duration-150 group shadow-sm">
                                <div class="w-8 h-8 border-2 border-emerald-200 shadow-sm overflow-hidden rounded-full mr-2 group-hover:scale-110 transition-transform">
                                    <img src="{{ Auth::user()->getAvatarUrl() }}" class="w-full h-full object-cover" alt="{{ Auth::user()->name }}">
                                </div>
                                <div class="font-bold text-sm">{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-emerald-50 bg-emerald-50/50">
                                <p class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Authenticated as</p>
                                <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fa-solid fa-user-gear mr-2 text-emerald-500"></i> {{ __('Settings') }}
                            </x-dropdown-link>
                            @if(!Auth::user()->hasRole('admin'))
                            <x-dropdown-link :href="route('wishlist.index')">
                                <i class="fa-solid fa-heart mr-2 text-amber-500"></i> {{ __('Wishlist') }}
                            </x-dropdown-link>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50 font-bold border-t border-emerald-50">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> {{ __('Secure Sign Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-[10px] font-black text-emerald-700 uppercase tracking-widest hover:text-emerald-900 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-emerald-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-amber-600 transition-all shadow-lg shadow-emerald-600/20">Sign Up</a>
                    </div>
                @endauth
            </div>

            <!-- Mobile User/Menu Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-500 hover:text-emerald-900 hover:bg-emerald-50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
        <div class="pt-4 pb-1 border-t border-emerald-100 bg-emerald-50/50">
            <div class="px-4 flex items-center">
                <div class="flex-shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover border-2 border-emerald-200 shadow-sm" src="{{ Auth::user()->getAvatarUrl() }}" alt="">
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-emerald-600">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                @if(Auth::check() && !Auth::user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                    {{ __('My Orders') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.*')">
                    {{ __('Wishlist') }}
                </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('home')">
                    {{ __('Store Front') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Settings') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold">
                        {{ __('Secure Sign Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-emerald-100 px-4 space-y-2 bg-emerald-50/50">
            <x-responsive-nav-link :href="route('login')">{{ __('Login') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">{{ __('Sign Up') }}</x-responsive-nav-link>
        </div>
        @endauth
    </div>
</nav>
<script>
    function updateClock() {
        const now = new Date();
        const options = { 
            timeZone: 'Asia/Karachi',
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true 
        };
        const formatter = new Intl.DateTimeFormat('en-US', options);
        document.getElementById('nav-clock').innerText = formatter.format(now);
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
