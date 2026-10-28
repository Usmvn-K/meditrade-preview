<div 
  x-data="{
    isExpanded: true,
    isMenuOpen: false,
    init() {
      // Set initial state based on current page scroll
      this.isExpanded = (window.pageYOffset || document.documentElement.scrollTop) < 80;
      
      const onScroll = () => {
        const current = window.pageYOffset || document.documentElement.scrollTop;
        // Keep expanded only at top of page, collapse quietly when browsing content
        if (current <= 80) {
          this.isExpanded = true;
        } else {
          this.isExpanded = false;
        }
      };

      window.addEventListener('scroll', onScroll, { passive: true });
    }
  }"
  class="relative z-50 select-none"
>
  <!-- 1. FLOATING RESPONSIVE PILL -->
  <div class="fixed top-3 sm:top-5 left-1/2 -translate-x-1/2 z-50 pointer-events-auto">
    <header 
      @click="if(!isExpanded) isExpanded = true"
      :style="isExpanded 
        ? 'width: min(94vw, 640px); height: 76px;' 
        : 'width: 76px; height: 76px;'"
      :class="isExpanded 
        ? 'px-4 sm:px-6 bg-white/95 border-stone-200/90 shadow-[0_16px_40px_-10px_rgba(0,0,0,0.22)] cursor-default' 
        : 'p-2.5 bg-white border-stone-300 shadow-[0_18px_36px_-6px_rgba(0,0,0,0.28)] cursor-pointer hover:scale-105 active:scale-95'"
      class="relative rounded-full border backdrop-blur-xl flex items-center justify-between overflow-hidden transition-[width,height,transform,box-shadow] duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] will-change-[width,height,transform]"
    >

      <!-- EXPANDED BAR -->
      <div 
        x-show="isExpanded"
        x-transition:enter="transition-opacity duration-200 delay-100"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-75"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="w-full flex items-center justify-between gap-2 sm:gap-4 shrink-0"
      >
        <!-- Large Scaled Logo (Left) -->
        <a href="{{ route('home') }}" class="flex items-center pl-1 sm:pl-2 group shrink-0">
          <img 
            src="{{ asset('uploads/settings/Meditrade-Logo.webp') }}" 
            alt="Meditrade Global" 
            class="h-11 sm:h-14 w-auto max-w-[170px] sm:max-w-[210px] object-contain transition-transform duration-200 group-hover:scale-105"
          />
        </a>

        <!-- Controls: Explore & Bag (No Admin) -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0 pr-1">
          <!-- Explore Menu Drawer Trigger -->
          <button 
            type="button"
            @click.stop="isMenuOpen = true"
            class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-stone-700 hover:text-stone-950 hover:bg-stone-100 rounded-full transition-colors duration-150 cursor-pointer"
          >
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Explore</span>
            <svg class="w-4 h-4 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="4" x2="20" y1="12" y2="12"></line>
              <line x1="4" x2="20" y1="6" y2="6"></line>
              <line x1="4" x2="20" y1="18" y2="18"></line>
            </svg>
          </button>

          <!-- Cart Trigger -->
          <button 
            type="button"
            onclick="if(typeof openCartDrawer === 'function') { openCartDrawer(); }"
            @click.stop="$dispatch('open-cart');"
            class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-full bg-emerald-50 border border-emerald-200/90 text-emerald-950 text-xs sm:text-sm font-semibold hover:bg-emerald-100 transition-all duration-150 cursor-pointer shadow-sm"
          >
            <svg class="w-4 h-4 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="8" cy="21" r="1"></circle>
              <circle cx="19" cy="21" r="1"></circle>
              <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
            </svg>
            <span class="font-bold tracking-tight">Cart</span>
            <span class="inline-flex items-center justify-center min-w-[1.35rem] h-5 px-1.5 rounded-full bg-emerald-600 text-[11px] font-bold text-white tracking-tight">
              {{ $cartCount ?? 0 }}
            </span>
          </button>
        </div>
      </div>

      <!-- COLLAPSED LARGE ICON PUCK -->
      <div 
        x-show="!isExpanded"
        x-transition:enter="transition-all duration-200 delay-100"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition-all duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="absolute inset-0 flex items-center justify-center p-2.5"
        title="Click to view navigation"
      >
        <img 
          src="{{ asset('uploads/settings/Meditrade-Logo.webp') }}" 
          alt="Meditrade Global" 
          class="w-full h-full object-contain pointer-events-none drop-shadow-sm p-0.5"
        />
      </div>

    </header>
  </div>

  <!-- 2. FULL EDITORIAL EXPLORE DRAWER -->
  <div 
    x-show="isMenuOpen" 
    x-cloak
    class="fixed inset-0 z-[100] overflow-hidden pointer-events-auto"
    @keydown.escape.window="isMenuOpen = false"
  >
    <div 
      x-show="isMenuOpen"
      x-transition:enter="transition-opacity duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition-opacity duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      @click="isMenuOpen = false"
      class="fixed inset-0 bg-stone-950/75 backdrop-blur-sm cursor-pointer"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-8 sm:pl-10">
      <div 
        x-show="isMenuOpen"
        x-transition:enter="transform transition duration-300 ease-out"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition duration-200 ease-in"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="w-screen max-w-sm sm:max-w-md bg-[#041E15] border-l border-emerald-500/20 text-white flex flex-col justify-between p-6 sm:p-8 shadow-2xl"
      >
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-emerald-500/15 pb-5">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
            <span class="text-xs uppercase tracking-[0.25em] text-emerald-200 font-bold">Meditrade Menu</span>
          </div>
          <button 
            type="button" 
            @click="isMenuOpen = false" 
            class="w-9 h-9 rounded-full bg-white/[0.08] flex items-center justify-center text-emerald-200 hover:text-white hover:bg-white/[0.15] transition-colors cursor-pointer"
          >
            ✕
          </button>
        </div>

        <!-- Links -->
        <nav class="flex flex-col gap-6 py-8">
          <a href="{{ route('home') }}" @click="isMenuOpen = false" class="text-2xl sm:text-3xl font-serif italic text-white hover:text-amber-300 transition-colors">
            Home &amp; Sanctuary
          </a>
          <a href="{{ url('/#remedies') }}" @click="isMenuOpen = false" class="text-2xl sm:text-3xl font-serif italic text-white hover:text-amber-300 transition-colors">
            Botanical Remedies
          </a>
          <a href="{{ url('/#about') }}" @click="isMenuOpen = false" class="text-2xl sm:text-3xl font-serif italic text-white hover:text-amber-300 transition-colors">
            Our Heritage &amp; Standards
          </a>
          <div class="h-[1px] bg-emerald-500/15 my-2"></div>
          <a href="{{ url('/contact') }}" @click="isMenuOpen = false" class="text-sm uppercase tracking-widest text-emerald-300/80 hover:text-emerald-200 transition-colors">
            Direct Inquiries &amp; Orders
          </a>
        </nav>

        <!-- Footer / Internal Portal Access -->
        <div class="pt-6 border-t border-emerald-500/15">
          <a 
            href="{{ url('/admin/login') }}"
            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl bg-white/[0.08] hover:bg-white/[0.14] text-xs font-semibold uppercase tracking-wider text-white transition-colors border border-emerald-400/20"
          >
            <svg class="w-3.5 h-3.5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <span>Staff Portal Access</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>