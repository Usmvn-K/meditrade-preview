@php
    $waNum = preg_replace('/[^0-9]/', '', \App\Models\Setting::getValue('social_whatsapp', '923000000000'));
    $waLink = 'https://wa.me/' . ($waNum ?: '923000000000');
@endphp

<footer class="bg-gradient-to-b from-[#062419] via-[#041a12] to-[#020e09] border-t border-emerald-500/15 text-white pt-16 pb-12 relative overflow-hidden">
  <!-- Atmospheric background glows -->
  <div class="pointer-events-none absolute -top-24 right-0 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-[130px]"></div>
  <div class="pointer-events-none absolute -bottom-24 left-0 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-[140px]"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <!-- 4-Column Responsive Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-14 border-b border-emerald-500/15">

      <!-- 1. Brand Column (Spans 5 cols) -->
      <div class="lg:col-span-5 flex flex-col justify-start">
        <a href="{{ route('home') }}" class="inline-block">
          <div class="inline-flex items-center p-2.5 px-4 rounded-2xl bg-white/95 border border-white/40 shadow-[0_8px_24px_rgba(0,0,0,0.3)] mb-6">
            <img 
              src="{{ asset('uploads/settings/Meditrade-Logo.webp') }}" 
              alt="Meditrade Global" 
              class="h-12 sm:h-14 w-auto object-contain"
            />
          </div>
        </a>
        
        <h3 class="text-xl sm:text-2xl font-serif italic text-amber-300 leading-snug mb-3 max-w-md">
          Global Standards. Natural Solutions. Modern Healthcare.
        </h3>
        
        <p class="text-sm sm:text-base text-emerald-100/75 leading-relaxed max-w-md">
          Artisanal, lab-tested herbal formulations making pure natural wellness a dependable, household standard in every Pakistani home.
        </p>
      </div>

      <!-- 2. Accreditation & Standards (Spans 2 cols) -->
      <div class="lg:col-span-2">
        <h4 class="text-xs font-mono uppercase tracking-[0.22em] text-amber-300 font-bold mb-5 flex items-center gap-2">
          <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
          Accreditation
        </h4>
        <ul class="space-y-3 text-xs text-emerald-100/75">
          <li class="flex items-start gap-2">
            <span class="text-amber-400 font-bold">✓</span>
            <span>DRAP Approved</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-amber-400 font-bold">✓</span>
            <span>GMP Certified Plant</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-amber-400 font-bold">✓</span>
            <span>ISO Quality Standard</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-amber-400 font-bold">✓</span>
            <span>University-Studied</span>
          </li>
        </ul>
      </div>

      <!-- 3. Legal & Governance (Spans 2 cols) -->
      <div class="lg:col-span-2">
        <h4 class="text-xs font-mono uppercase tracking-[0.22em] text-amber-300 font-bold mb-5 flex items-center gap-2">
          <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
          Legal & Privacy
        </h4>
        <ul class="space-y-3 text-xs sm:text-sm text-emerald-100/80">
          <li>
            <a href="{{ url('/privacy-policy') }}" class="hover:text-amber-300 transition-colors">Privacy Policy</a>
          </li>
          <li>
            <a href="{{ url('/terms-of-service') }}" class="hover:text-amber-300 transition-colors">Terms of Service</a>
          </li>
          <li>
            <a href="{{ url('/shipping-delivery') }}" class="hover:text-amber-300 transition-colors">Shipping & COD</a>
          </li>
          <li>
            <a href="{{ url('/return-policy') }}" class="hover:text-amber-300 transition-colors">Returns & Guarantee</a>
          </li>
        </ul>
      </div>

      <!-- 4. Direct Support & Concierge (Spans 3 cols) -->
      <div class="lg:col-span-3 flex flex-col justify-between">
        <div>
          <h4 class="text-xs font-mono uppercase tracking-[0.22em] text-amber-300 font-bold mb-5 flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
            Direct Inquiries
          </h4>
          <div class="space-y-3 text-xs sm:text-sm text-emerald-100/80">
            <a href="{{ $waLink }}" target="_blank" class="flex items-center gap-2 hover:text-emerald-300 transition-colors">
              <span class="text-emerald-400 text-base">💬</span>
              <span>WhatsApp Order Concierge</span>
            </a>
            <div class="flex items-center gap-2 text-emerald-100/70">
              <span>🚚</span>
              <span>Cash on Delivery Available</span>
            </div>
          </div>
        </div>

        <div class="mt-8">
          <a 
            href="{{ url('/admin/login') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/[0.08] hover:bg-white/[0.15] border border-emerald-400/20 text-xs font-semibold text-emerald-200 hover:text-white transition-all shadow-sm"
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

    <!-- Bottom Legal Bar -->
    <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-emerald-100/50">
      <p>© {{ date('Y') }} MediTrade Global. All rights reserved. Handcrafted natural remedies.</p>
      <div class="flex items-center gap-4 text-emerald-200/60">
        <span>100% Secure Checkout</span>
        <span>•</span>
        <span>Nationwide Dispatch</span>
      </div>
    </div>
  </div>
</footer>
