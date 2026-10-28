<!-- Modern Herbal Care Preloader -->
<div id="website-preloader" class="fixed inset-0 z-[9999] bg-[#022C22] flex flex-col items-center justify-center transition-all duration-700 ease-in-out opacity-100 pointer-events-auto">

    <!-- Background Subtle Glow Elements -->
    <div class="absolute w-[500px] h-[500px] bg-emerald-600/15 rounded-full blur-[140px] pointer-events-none animate-pulse"></div>
    <div class="absolute w-[400px] h-[400px] bg-amber-500/15 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative z-10 flex flex-col items-center text-center px-4">

        <!-- Logo Container with Soft Herbal Glow Pulse -->
        <div class="relative mb-6 group">
            <!-- Pulsing Ring around Logo -->
            <div class="absolute -inset-4 bg-gradient-to-r from-emerald-500 via-emerald-300 to-amber-500 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
            
            <div class="relative bg-white/10 backdrop-blur-2xl p-6 rounded-3xl border border-emerald-400/30 shadow-2xl flex flex-col items-center justify-center">
                <div class="w-12 h-12 rounded-full bg-emerald-700/80 border border-emerald-400/40 flex items-center justify-center text-emerald-200 text-xl mb-2 animate-bounce">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <img src="{{ mediaUrl(\App\Models\Setting::getValue('site_logo'), asset('images/EVN.png')) }}"
                     alt="{{ \App\Models\Setting::getValue('site_name', 'Gohar Herbal Care') }}"
                     class="h-16 md:h-20 w-auto object-contain animate-subtle-scale">
            </div>
        </div>

        <!-- Brand Name -->
        <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-wider mb-1 font-friendly">
            {{ \App\Models\Setting::getValue('site_name', 'Gohar Herbal Care') }}
        </h2>

        <!-- Slogan / Subtitle -->
        <p class="text-xs text-emerald-200/80 uppercase tracking-[0.3em] font-bold mb-6">
            {{ \App\Models\Setting::getValue('site_slogan', '100% Pure Organic & Natural Remedies') }}
        </p>

        <!-- Progress Bar Indicator -->
        <div class="w-52 h-1.5 bg-emerald-950/80 border border-emerald-800/40 rounded-full overflow-hidden relative mt-2">
            <div class="h-full bg-gradient-to-r from-emerald-600 via-emerald-300 to-amber-400 rounded-full animate-preloader-progress"></div>
        </div>

        <div class="mt-4 text-[10px] text-emerald-300/60 uppercase tracking-[0.2em] font-medium flex items-center gap-2">
            <i class="fa-solid fa-leaf text-xs text-emerald-400"></i> Loading Pure Organic Goodness...
        </div>

    </div>
</div>

<style>
    @keyframes subtleScale {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.06); }
    }
    .animate-subtle-scale {
        animation: subtleScale 2s infinite ease-in-out;
    }

    @keyframes preloaderProgress {
        0% { width: 0%; transform: translateX(-100%); }
        50% { width: 70%; transform: translateX(0%); }
        100% { width: 100%; transform: translateX(100%); }
    }
    .animate-preloader-progress {
        animation: preloaderProgress 1.6s infinite ease-in-out;
    }
</style>

<script>
    (function () {
        function hidePreloader() {
            const preloader = document.getElementById('website-preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                preloader.style.pointerEvents = 'none';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 700);
            }
        }

        // Hide preloader when page finishes loading
        if (document.readyState === 'complete') {
            setTimeout(hidePreloader, 400);
        } else {
            window.addEventListener('load', function () {
                setTimeout(hidePreloader, 400);
            });
        }

        // Safety fallback after 3 seconds in case window load stalls
        setTimeout(hidePreloader, 3000);
    })();
</script>
