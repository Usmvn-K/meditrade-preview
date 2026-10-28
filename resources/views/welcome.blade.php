@extends('layouts.public')

@section('title', \App\Models\Setting::getValue('site_name', 'Gohar Herbal Care') . ' | 100% Pure Organic & Natural Remedies')
@section('description', \App\Models\Setting::getValue('meta_description', 'Your trusted destination for 100% pure organic herbal teas, essential oils, natural remedies, and botanical skincare.'))

@push('styles')
    <style>
        .hero-gradient-herbal {
            background: linear-gradient(135deg, #022c22 0%, #052e16 35%, #14532d 70%, #d97706 100%);
        }
        .gradient-text-herbal {
            background: linear-gradient(135deg, #86efac, #ffffff, #fcd34d);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .service-card:hover { transform: translateY(-8px) scale(1.02); }
        .pulse-glow-herbal { animation: pulseGlowHerbal 2.5s ease-in-out infinite; }
        @keyframes pulseGlowHerbal {
            0%, 100% { box-shadow: 0 0 25px rgba(21, 128, 61, 0.4); }
            50% { box-shadow: 0 0 45px rgba(134, 239, 172, 0.7); }
        }
        .marquee-container { mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); }
        .marquee-content { animation: scroll 40s linear infinite; }
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        
        /* Swiper Custom Styles */
        .swiper-button-next, .swiper-button-prev {
            background-color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            color: #15803d;
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 18px;
            font-weight: bold;
        }
        .swiper-pagination-bullet-active {
            background: #15803d;
        }

        /* Premium Botanical Card Styles */
        .premium-card {
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }
        .premium-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px -12px rgba(21, 128, 61, 0.25);
        }
        .shine-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(
                to right,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transform: skewX(-25deg);
            transition: 0.7s;
            z-index: 5;
        }
        .premium-card:hover .shine-effect::before {
            left: 150%;
        }
        .glass-tag {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        @keyframes subtle-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.04); opacity: 0.9; }
        }
        .animate-subtle-pulse {
            animation: subtle-pulse 3s infinite ease-in-out;
        }
        .font-friendly { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        @keyframes floating {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-16px) rotate(1.5deg); }
        }
        .animate-floating { animation: floating 6s ease-in-out infinite; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .hero-title-shadow {
            text-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        .font-editorial {
            font-family: 'Playfair Display', Georgia, serif;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@section('content')
    @php $customHeroImg = \App\Models\Setting::getValue('hero_banner_image'); @endphp
    <!-- Hero Section -->
    <div class="relative min-h-[90vh] flex items-center bg-[#022C22] overflow-hidden" id="hero-container"
         @if($customHeroImg) style="background-image: linear-gradient(to right, rgba(2, 44, 34, 0.92), rgba(5, 46, 22, 0.8)), url('{{ $customHeroImg }}'); background-size: cover; background-position: center;" @endif>
        <!-- Modern Botanical Background Architecture -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-emerald-600/20 rounded-full blur-[160px] -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-amber-500/15 rounded-full blur-[130px] translate-y-1/2 -translate-x-1/4"></div>
            <div class="absolute inset-0" style="background-image: url('https://www.transparenttextures.com/patterns/leaf.png'); opacity: 0.08;"></div>
        </div>

        <!-- Ambient Lighting & Radial Depth Orbs -->
        <div class="pointer-events-none absolute -top-24 right-0 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute top-1/4 -left-20 w-[450px] h-[450px] bg-emerald-500/10 rounded-full blur-3xl"></div>

        <div class="relative z-30 max-w-[1400px] mx-auto px-6 py-16 grid lg:grid-cols-2 gap-16 items-center h-full">
            <!-- Left Content -->
            <div class="text-left space-y-6">
                <div class="flex items-center gap-2.5 mb-4">
                    <span class="text-amber-400/90 text-sm font-serif italic tracking-wide">
                        ✦ Pure Botanical Wellness &amp; Organic Health
                    </span>
                    <span class="h-[1px] w-12 bg-gradient-to-r from-amber-400/60 to-transparent"></span>
                </div>

                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black uppercase tracking-tight leading-[1.05] hero-title-shadow">
                    <span class="block text-white">MEDITRADE GLOBAL</span>
                    <span class="block text-emerald-300">BOTANICAL HEALING</span>
                </h1>
                
                <div class="border-l-2 border-emerald-400/30 pl-5 py-1 max-w-xl">
                    <p class="text-base sm:text-lg text-emerald-100/80 font-normal leading-relaxed tracking-wide max-w-xl font-friendly">
                        Curating the finest organic botanicals and artisanal wellness remedies. Rigorously lab-tested for uncompromising daily vitality and holistic health.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-2">
                    <a href="#remedies" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 text-stone-950 font-bold text-xs uppercase tracking-widest shadow-lg shadow-amber-500/25 hover:brightness-110 hover:shadow-amber-500/40 transition-all duration-200 group">
                        <span>ORDER NATURAL REMEDIES</span>
                        <i class="fa-solid fa-leaf group-hover:rotate-45 transition-transform"></i>
                    </a>
                    <a href="#showcase" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full border border-emerald-400/30 text-emerald-100 font-semibold text-xs uppercase tracking-widest hover:bg-white/[0.07] hover:border-emerald-400/50 transition-all duration-200">
                        <span>EXPLORE COLLECTION</span>
                    </a>
                </div>

                <!-- Quick Stats Badges -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-emerald-800/40">
                    <div>
                        <div class="text-2xl font-black text-emerald-300">100%</div>
                        <div class="text-[10px] text-emerald-100/60 uppercase tracking-wider font-bold">Organic Pure</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-amber-400">50+</div>
                        <div class="text-[10px] text-emerald-100/60 uppercase tracking-wider font-bold">Herbal Formulations</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-emerald-300">Lab Tested</div>
                        <div class="text-[10px] text-emerald-100/60 uppercase tracking-wider font-bold">Certified Quality</div>
                    </div>
                </div>
            </div>

            <!-- Right Visual Showcase -->
            <div class="relative hidden lg:block h-[85%]">
                <div class="relative z-10 grid grid-cols-2 gap-4 h-full animate-floating">
                    <!-- Left Column (Card 1 & Card 3) -->
                    <div class="space-y-4 pt-10">
                        <!-- Card 1: Tall Left Card (Wild Sidr Harvest) -->
                        <div class="relative h-[60%] rounded-[2.5rem] overflow-hidden border border-emerald-400/20 shadow-2xl group">
                            <img src="{{ asset('images/bento-honey-harvest.jpg') }}" class="w-full h-full object-cover rounded-3xl group-hover:scale-105 transition-transform duration-700" alt="Wild Sidr Harvest">
                        </div>

                        <!-- Card 3: Bottom-Left Emerald Card (Doorstep Assurance) -->
                        <div class="h-[35%] rounded-[2.5rem] overflow-hidden border border-emerald-400/20 shadow-2xl bg-emerald-950/90 p-6 flex flex-col justify-end">
                            <i class="fa-solid fa-shield-halved text-emerald-400 text-2xl mb-2"></i>
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">DOORSTEP ASSURANCE</h3>
                            <p class="text-emerald-200/80 text-[11px] font-medium leading-snug mt-1">Open & inspect package before paying • Nationwide Cash on Delivery.</p>
                        </div>
                    </div>

                    <!-- Right Column (Card 2 & Card 4) -->
                    <div class="space-y-4">
                        <!-- Card 2: Top-Right Amber Card (Traditional Formulation) -->
                        <div class="h-[35%] rounded-[2.5rem] overflow-hidden border border-amber-400/30 shadow-2xl bg-gradient-to-br from-amber-600 to-amber-700 p-6 flex flex-col justify-end">
                            <h3 class="text-xl sm:text-2xl font-black text-white uppercase tracking-tight mb-1">TRADITIONAL FORMULATION</h3>
                            <p class="text-amber-100/90 text-[11px] font-medium leading-snug">Cold-pressed ginger, garlic, lemon & apple cider brewed with wild Sidr honey.</p>
                        </div>

                        <!-- Card 4: Bottom-Right Card (Raw Botanicals) -->
                        <div class="relative h-[60%] rounded-[2.5rem] overflow-hidden border border-emerald-400/20 shadow-2xl group">
                            <img src="{{ asset('images/bento-raw-botanicals.jpg') }}" class="w-full h-full object-cover rounded-3xl group-hover:scale-105 transition-transform duration-700" alt="Zero Chemicals Raw Botanicals">
                            <div class="absolute bottom-4 left-4 right-4 z-10 bg-emerald-950/85 backdrop-blur-md px-3.5 py-2 rounded-2xl border border-emerald-400/20 text-center shadow-lg">
                                <span class="text-[10px] font-black text-emerald-200 uppercase tracking-wider">ZERO CHEMICALS • 100% NATURAL BOTANICALS</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Floating Botanical Glass Card -->
                <div class="absolute -top-6 -left-8 z-20 glass-card px-5 py-3.5 rounded-2xl animate-subtle-pulse border border-emerald-400/30 shadow-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-amber-300 shadow-md">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-black text-white uppercase tracking-wider">WILD SIDR HARVEST • 100% UNFILTERED</div>
                            <div class="text-[9px] text-emerald-200/80 uppercase tracking-widest font-bold">Raw & Lab Certified Guarantee</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Herbal Trust Features Banner -->
    <div class="py-12 bg-emerald-900 border-y border-emerald-800" id="herbal-features">
        <div class="max-w-[1400px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach([
                    ['100% Pure & Organic', 'fa-leaf', 'Free from synthetic chemicals, parabens, and additives.'],
                    ['Direct Farm Sourced', 'fa-seedling', 'Sourced directly from verified organic botanical farms.'],
                    ['Certified Herbalists', 'fa-user-nurse', 'Formulated under expert herbalist supervision.'],
                    ['Eco-Friendly Packaging', 'fa-recycle', 'Sustainable glass & recyclable packaging choices.']
                ] as [$title, $icon, $desc])
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-emerald-950/40 border border-emerald-800/40">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-800/50 flex-shrink-0 flex items-center justify-center text-emerald-300 text-xl">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-white uppercase tracking-tight mb-1">{{ $title }}</h4>
                        <p class="text-xs text-emerald-200/60 leading-relaxed">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Product Cinematic Spotlight Section -->
    <div id="showcase" 
         class="py-24 bg-gradient-to-br from-[#022c22] via-[#052e16] to-[#022018] relative overflow-hidden text-white border-y border-emerald-800/50"
         x-data="{
             activeTab: 'tonic',
             isPlaying: true,
             isMuted: true,
             products: {
                 tonic: {
                     id: 2,
                     title: 'HABIBI HERBAL TONIC',
                     desc: 'Formulated with Ginger, Garlic, Lemon, Honey, and Apple Cider Vinegar for daily vitality.',
                     price: 'PKR 1,200',
                     oldPrice: 'PKR 1,500',
                     discount: 'SAVE 20% OFF',
                     badgeSub: 'Cinematic Product Preview',
                     videoSrc: '{{ asset('uploads/videos/habibi-tonic-preview.mp4') }}',
                     poster: '{{ asset('uploads/products/habibi-tonic.png') }}',
                     specs: [
                         { title: '✦ 100% Cold-Pressed', desc: 'Pure ginger, garlic, lemon & apple cider' },
                         { title: '✦ Raw Honey Carrier', desc: 'Natural unheated Sidr preservation' },
                         { title: '✦ Bio-Active Vitality', desc: 'Rapid liquid absorption for daily wellness' },
                         { title: '✦ Zero Synthetics', desc: 'No artificial preservatives or water dilution' }
                     ]
                 },
                 honey: {
                     id: 1,
                     title: 'HABIBI NATURAL HONEY',
                     desc: '100% Natural, hand-harvested, and unprocessed golden honey rich in live bioactive enzymes.',
                     price: 'PKR 1,500',
                     oldPrice: 'PKR 1,800',
                     discount: 'SAVE 17% OFF',
                     badgeSub: 'Pure Sidr Harvest',
                     videoSrc: '{{ asset('uploads/videos/1788705048_v2_Generating_branding_video_for_honey_202609061930.mp4') }}',
                     poster: '{{ asset('uploads/products/Habibi-Honey.png') }}',
                     specs: [
                         { title: '✦ 100% Raw Sidr Nectar', desc: 'Hand-harvested from pristine mountain flora' },
                         { title: '✦ Unheated Extraction', desc: 'Gravity strained to preserve active diastase enzymes' },
                         { title: '✦ Natural Immunity', desc: 'Rich in antimicrobial defensin peptides' },
                         { title: '✦ Zero Sugar Added', desc: '100% pure wild nectar with zero adulteration' }
                     ]
                 }
             },
             get current() {
                 return this.products[this.activeTab];
             },
             setTab(tab) {
                 if (this.activeTab === tab) return;
                 this.activeTab = tab;
                 const video = this.$refs.featuredVideo;
                 if (video) {
                     video.src = this.current.videoSrc;
                     video.poster = this.current.poster;
                     video.load();
                     video.play().catch(() => {});
                     this.isPlaying = true;
                 }
             },
             togglePlay() {
                 const video = this.$refs.featuredVideo;
                 if (!video) return;
                 if (video.paused) {
                     video.play();
                     this.isPlaying = true;
                 } else {
                     video.pause();
                     this.isPlaying = false;
                 }
             },
             toggleMute() {
                 const video = this.$refs.featuredVideo;
                 if (!video) return;
                 video.muted = !video.muted;
                 this.isMuted = video.muted;
             }
         }">
        <!-- Ambient Glowing Background Accents -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- Centered subtle amber glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[750px] h-[500px] bg-amber-500/5 rounded-full blur-[120px]"></div>
            <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-[140px] animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-[600px] h-[600px] bg-amber-500/10 rounded-full blur-[160px]"></div>
            <div class="absolute inset-0" style="background-image: url('https://www.transparenttextures.com/patterns/leaf.png'); opacity: 0.05;"></div>
        </div>

        <div class="max-w-[1400px] mx-auto px-6 relative z-10">
            <!-- Top Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 mb-3">
                    <span class="text-xs uppercase tracking-[0.25em] text-amber-300/90 font-serif italic">
                        ✦ Master Apothecary Formulations
                    </span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                    OUR PREMIUM HERBAL ESSENTIALS
                </h2>
                <p class="text-sm sm:text-base text-emerald-100/80 max-w-xl mx-auto mt-2">
                    Handcrafted natural solutions for immunity, energy, and radiant health.
                </p>
            </div>

            <!-- Main Showcase Grid -->
            <div class="grid lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left: Video Player Showcase (7 cols) -->
                <div class="lg:col-span-7 relative group">
                    <div class="relative rounded-[2.5rem] overflow-hidden border border-emerald-400/30 bg-emerald-950/80 shadow-2xl shadow-emerald-950/80">
                        <!-- Cinematic Video Element -->
                        <div class="relative aspect-video md:aspect-[16/10] overflow-hidden bg-black">
                            <video x-ref="featuredVideo" 
                                   :src="current.videoSrc" 
                                   :poster="current.poster" 
                                   src="{{ asset('uploads/videos/habibi-tonic-preview.mp4') }}" 
                                   poster="{{ asset('uploads/products/habibi-tonic.png') }}"
                                   class="w-full h-full object-cover" 
                                   autoplay loop muted playsinline>
                                <source :src="current.videoSrc" src="{{ asset('uploads/videos/habibi-tonic-preview.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                            <!-- Video Overlay Elements -->
                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-transparent to-black/30 pointer-events-none"></div>

                            <!-- Floating Badges on Video -->
                            <div class="absolute top-6 left-6 flex items-center gap-3">
                                <span class="px-4 py-2 rounded-full bg-emerald-900/80 backdrop-blur-md border border-emerald-400/30 text-[10px] font-black text-emerald-200 uppercase tracking-widest flex items-center gap-2 shadow-lg">
                                    <i class="fa-solid fa-circle-check text-amber-400"></i>
                                    100% Organic Certified
                                </span>
                            </div>

                            <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between pointer-events-auto">
                                <div class="flex items-center gap-3">
                                    <button @click="togglePlay()" 
                                            class="w-12 h-12 rounded-2xl bg-white/20 hover:bg-amber-500 hover:text-gray-900 text-white border border-white/30 backdrop-blur-md flex items-center justify-center transition-all duration-300 shadow-xl group/btn cursor-pointer" 
                                            aria-label="Play or pause video">
                                        <i class="fa-solid text-sm" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
                                    </button>
                                    <button @click="toggleMute()" 
                                            class="w-12 h-12 rounded-2xl bg-white/20 hover:bg-emerald-600 text-white border border-white/30 backdrop-blur-md flex items-center justify-center transition-all duration-300 shadow-xl cursor-pointer" 
                                            aria-label="Mute or unmute video">
                                        <i class="fa-solid text-sm" :class="isMuted ? 'fa-volume-xmark' : 'fa-volume-high'"></i>
                                    </button>
                                </div>

                                <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-2xl bg-black/60 backdrop-blur-md border border-white/10 text-xs font-bold text-amber-300">
                                    <i class="fa-solid fa-film text-amber-400"></i>
                                    <span x-text="current.badgeSub">Cinematic Product Preview</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Video Selector Tabs (Change 2) -->
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <button type="button" 
                                @click="setTab('tonic')" 
                                :class="activeTab === 'tonic' 
                                    ? 'flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/[0.08] border border-amber-400/50 shadow-md text-white transition-all cursor-pointer text-left group' 
                                    : 'flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/[0.02] border border-white/[0.07] text-stone-300 hover:text-white hover:bg-white/[0.06] transition-all cursor-pointer text-left group'">
                            <div class="w-9 h-9 rounded-xl bg-amber-400/15 flex items-center justify-center text-amber-400 shrink-0">
                                <i class="fa-solid fa-play text-xs"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white group-hover:text-amber-300 transition-colors">Habibi Herbal Tonic</div>
                                <div class="text-[10px] text-emerald-200/60 font-semibold">Cinematic Product Preview</div>
                            </div>
                        </button>
                        <button type="button" 
                                @click="setTab('honey')" 
                                :class="activeTab === 'honey' 
                                    ? 'flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/[0.08] border border-amber-400/50 shadow-md text-white transition-all cursor-pointer text-left group' 
                                    : 'flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/[0.02] border border-white/[0.07] text-stone-300 hover:text-white hover:bg-white/[0.06] transition-all cursor-pointer text-left group'">
                            <div class="w-9 h-9 rounded-xl bg-amber-400/15 flex items-center justify-center text-amber-400 shrink-0">
                                <i class="fa-solid fa-play text-xs"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white group-hover:text-amber-300 transition-colors">Habibi Natural Honey</div>
                                <div class="text-[10px] text-emerald-200/60 font-semibold">Pure Sidr Harvest</div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Right: Product Card & Action Details (5 cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Product Title & Rating -->
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <div class="flex text-amber-400 text-sm">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="text-xs font-bold text-amber-200">5.0 (1,840+ Reviews)</span>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tight leading-tight transition-all duration-300"
                            x-text="current.title">
                            HABIBI HERBAL TONIC
                        </h3>
                        <p class="text-xs md:text-sm text-emerald-100/70 leading-relaxed font-medium transition-all duration-300"
                           x-text="current.desc">
                            Formulated with Ginger, Garlic, Lemon, Honey, and Apple Cider Vinegar for daily vitality.
                        </p>
                    </div>

                    <!-- Feature Matrix Badges (Change 3) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 my-5">
                        <div class="p-3.5 rounded-2xl bg-white/[0.04] border border-emerald-500/15 backdrop-blur-sm">
                            <span class="block text-xs font-bold text-emerald-200" x-text="current.specs[0].title">✦ 100% Cold-Pressed</span>
                            <span class="block text-[11px] text-emerald-100/60 leading-tight mt-0.5" x-text="current.specs[0].desc">Pure ginger, garlic, lemon & apple cider</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/[0.04] border border-emerald-500/15 backdrop-blur-sm">
                            <span class="block text-xs font-bold text-emerald-200" x-text="current.specs[1].title">✦ Raw Honey Carrier</span>
                            <span class="block text-[11px] text-emerald-100/60 leading-tight mt-0.5" x-text="current.specs[1].desc">Natural unheated Sidr preservation</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/[0.04] border border-emerald-500/15 backdrop-blur-sm">
                            <span class="block text-xs font-bold text-emerald-200" x-text="current.specs[2].title">✦ Bio-Active Vitality</span>
                            <span class="block text-[11px] text-emerald-100/60 leading-tight mt-0.5" x-text="current.specs[2].desc">Rapid liquid absorption for daily wellness</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/[0.04] border border-emerald-500/15 backdrop-blur-sm">
                            <span class="block text-xs font-bold text-emerald-200" x-text="current.specs[3].title">✦ Zero Synthetics</span>
                            <span class="block text-[11px] text-emerald-100/60 leading-tight mt-0.5" x-text="current.specs[3].desc">No artificial preservatives or water dilution</span>
                        </div>
                    </div>

                    <!-- Pricing & Launch Card (Change 4) -->
                    <div class="p-5 rounded-3xl bg-black/25 border border-emerald-500/20 shadow-xl mt-4">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="block text-[10px] uppercase font-bold tracking-widest text-emerald-300/80">Special Launch Price</span>
                                <div class="flex items-baseline gap-2 mt-0.5">
                                    <span class="text-3xl font-black text-amber-400" x-text="current.price">PKR 1,200</span>
                                    <span class="text-sm line-through text-stone-400 font-medium" x-text="current.oldPrice">PKR 1,500</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-400/10 border border-amber-400/30 text-amber-300"
                                  x-text="current.discount">
                                SAVE 20% OFF
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <a :href="'{{ url('/services') }}/' + current.id" 
                               @click.prevent="if(window.addToCartAjax){ window.addToCartAjax(current.id, 1); } else { window.location.href='{{ url('/add-to-cart') }}/' + current.id; } $dispatch('open-cart');"
                               class="py-4 px-6 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-gray-950 font-black rounded-2xl text-xs uppercase tracking-wider text-center transition-all duration-300 shadow-xl shadow-amber-900/30 flex items-center justify-center gap-2 group cursor-pointer">
                                <span>Order Now</span>
                                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('contact') }}" class="py-4 px-6 bg-white/10 hover:bg-white/20 text-white font-bold rounded-2xl text-xs uppercase tracking-wider text-center border border-white/20 transition-all flex items-center justify-center gap-2">
                                <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i>
                                <span>Inquire Us</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Artisanal Botanical Apothecary - The Dual Remedy Regimen -->
    <section id="remedies" 
             class="bg-[#041E15] text-white py-20 px-4 sm:px-6 relative overflow-hidden"
             x-data="{
                 dossierOpen: false,
                 selectedProduct: 'honey',
                 quantity: 1,
                 openDossier(prod) {
                     this.selectedProduct = prod;
                     this.quantity = 1;
                     this.dossierOpen = true;
                 },
                 get currentPrice() {
                     return this.selectedProduct === 'honey' ? 1500 : 1200;
                 },
                 get currentId() {
                     return this.selectedProduct === 'honey' ? 1 : 2;
                 },
                 get totalPriceFormatted() {
                     return 'PKR ' + (this.currentPrice * this.quantity).toLocaleString();
                 },
                 addToBagFromDrawer() {
                     const id = this.currentId;
                     const qty = this.quantity;
                     if (window.addToCartAjax) {
                         window.addToCartAjax(id, qty);
                     } else {
                         window.location.href = '{{ url('/add-to-cart') }}/' + id;
                     }
                     this.dossierOpen = false;
                     this.$dispatch('open-cart');
                 }
             }">

        <!-- Ambient Background Botanical Glows (Left Emerald, Right Warm Honey) -->
        <div class="absolute top-1/3 -left-20 w-[550px] h-[550px] bg-emerald-500/15 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute bottom-1/3 -right-20 w-[550px] h-[550px] bg-amber-500/15 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-emerald-600/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-6xl mx-auto relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs uppercase tracking-[0.25em] text-amber-300 font-serif italic">✦ Artisanal Botanical Apothecary</span>
                <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white mt-2">The Dual Remedy Regimen</h2>
                <p class="text-sm sm:text-base text-emerald-100/70 max-w-xl mx-auto mt-2">Two master formulations crafted for immune defense, cardiovascular health, and sustained vitality.</p>
            </div>

            <!-- Centered 2-Column Split Grid -->
            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
                
                <!-- Card 1: Habibi Natural Honey -->
                <div class="rounded-3xl bg-white/[0.03] border border-emerald-500/15 p-6 sm:p-8 hover:border-amber-400/40 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden backdrop-blur-sm">
                    <!-- Subtle Corner Ambient Light -->
                    <div class="absolute top-0 right-0 w-44 h-44 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/15 transition-all duration-500 pointer-events-none"></div>

                    <div>
                        <!-- Product Bottle Shot -->
                        <div class="relative h-64 sm:h-72 rounded-2xl bg-gradient-to-b from-white/[0.04] to-black/20 border border-emerald-500/10 flex items-center justify-center p-6 overflow-hidden">
                            <span class="absolute top-3 left-3 z-20 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-black/60 text-amber-300 border border-amber-400/30 backdrop-blur-md shadow-sm">Raw Sidr Harvest</span>
                            <div class="absolute inset-0 bg-radial from-amber-400/10 via-transparent to-transparent opacity-60 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <img src="{{ asset('uploads/products/Habibi-Honey.png') }}" 
                                 alt="Habibi Natural Honey" 
                                 class="h-full w-auto max-w-full object-contain relative z-10 group-hover:scale-105 transition-transform duration-500 drop-shadow-[0_16px_28px_rgba(0,0,0,0.5)]">
                        </div>

                        <!-- Card Content -->
                        <div class="mt-6 space-y-2">
                            <span class="text-xs uppercase tracking-[0.2em] text-amber-400 font-mono font-bold block">01 • Daily Immunity</span>
                            <h3 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white group-hover:text-amber-300 transition-colors">
                                Habibi Natural Honey
                            </h3>
                            <p class="text-xs sm:text-sm text-emerald-100/70 leading-relaxed">
                                Unheated, cold-harvested wild Sidr nectar dense in live bioactive enzymes, antioxidant phenolics, and natural immune peptides.
                            </p>
                        </div>
                    </div>

                    <!-- Pricing & Action Buttons -->
                    <div class="mt-6 pt-5 border-t border-emerald-500/15">
                        <div class="flex items-baseline justify-between mb-5">
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl sm:text-3xl font-black text-amber-400 tracking-tight">PKR 1,500</span>
                                <span class="text-xs text-emerald-100/40 line-through">PKR 1,800</span>
                            </div>
                            <span class="text-[11px] font-mono text-emerald-300/80 uppercase tracking-wider">500g Glass Jar</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" 
                                    @click="openDossier('honey')" 
                                    class="py-3 px-3 sm:px-4 rounded-xl border border-emerald-500/30 hover:border-amber-400/60 bg-white/[0.04] hover:bg-white/[0.08] text-emerald-100 hover:text-white text-xs font-bold uppercase tracking-wider transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                                <i class="fa-solid fa-magnifying-glass text-[11px] text-amber-300"></i>
                                <span class="truncate">Inspect Formulation</span>
                            </button>
                            <button type="button" 
                                    @click="if(window.addToCartAjax){ window.addToCartAjax(1, 1); } else { window.location.href='{{ route('cart.add', 1) }}'; } $dispatch('open-cart');" 
                                    class="py-3 px-3 sm:px-4 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 hover:from-amber-400 hover:to-amber-300 text-slate-950 font-black text-xs uppercase tracking-wider transition-all duration-200 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-[1.02] active:scale-98 flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-bag-shopping text-xs"></i>
                                <span>Add to Bag</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Habibi Herbal Tonic -->
                <div class="rounded-3xl bg-white/[0.03] border border-emerald-500/15 p-6 sm:p-8 hover:border-amber-400/40 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden backdrop-blur-sm">
                    <!-- Subtle Corner Ambient Light -->
                    <div class="absolute top-0 right-0 w-44 h-44 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/15 transition-all duration-500 pointer-events-none"></div>

                    <div>
                        <!-- Product Bottle Shot -->
                        <div class="relative h-64 sm:h-72 rounded-2xl bg-gradient-to-b from-white/[0.04] to-black/20 border border-emerald-500/10 flex items-center justify-center p-6 overflow-hidden">
                            <span class="absolute top-3 left-3 z-20 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-black/60 text-emerald-300 border border-emerald-400/30 backdrop-blur-md shadow-sm">Cold-Pressed Elixir</span>
                            <div class="absolute inset-0 bg-radial from-emerald-400/10 via-transparent to-transparent opacity-60 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <img src="{{ asset('uploads/products/habibi-tonic.png') }}" 
                                 alt="Habibi Herbal Tonic" 
                                 class="h-full w-auto max-w-full object-contain relative z-10 group-hover:scale-105 transition-transform duration-500 drop-shadow-[0_16px_28px_rgba(0,0,0,0.5)]">
                        </div>

                        <!-- Card Content -->
                        <div class="mt-6 space-y-2">
                            <span class="text-xs uppercase tracking-[0.2em] text-amber-400 font-mono font-bold block">02 • Vitality & Circulation</span>
                            <h3 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white group-hover:text-amber-300 transition-colors">
                                Habibi Herbal Tonic
                            </h3>
                            <p class="text-xs sm:text-sm text-emerald-100/70 leading-relaxed">
                                Artisanal cold-pressed synergistic elixir of organic garlic, ginger, lemon, and raw mother apple cider vinegar for cardiovascular flow.
                            </p>
                        </div>
                    </div>

                    <!-- Pricing & Action Buttons -->
                    <div class="mt-6 pt-5 border-t border-emerald-500/15">
                        <div class="flex items-baseline justify-between mb-5">
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl sm:text-3xl font-black text-amber-400 tracking-tight">PKR 1,200</span>
                                <span class="text-xs text-emerald-100/40 line-through">PKR 1,500</span>
                            </div>
                            <span class="text-[11px] font-mono text-emerald-300/80 uppercase tracking-wider">500ml Bottle</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" 
                                    @click="openDossier('tonic')" 
                                    class="py-3 px-3 sm:px-4 rounded-xl border border-emerald-500/30 hover:border-amber-400/60 bg-white/[0.04] hover:bg-white/[0.08] text-emerald-100 hover:text-white text-xs font-bold uppercase tracking-wider transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                                <i class="fa-solid fa-magnifying-glass text-[11px] text-amber-300"></i>
                                <span class="truncate">Inspect Formulation</span>
                            </button>
                            <button type="button" 
                                    @click="if(window.addToCartAjax){ window.addToCartAjax(2, 1); } else { window.location.href='{{ route('cart.add', 2) }}'; } $dispatch('open-cart');" 
                                    class="py-3 px-3 sm:px-4 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 hover:from-amber-400 hover:to-amber-300 text-slate-950 font-black text-xs uppercase tracking-wider transition-all duration-200 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-[1.02] active:scale-98 flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-bag-shopping text-xs"></i>
                                <span>Add to Bag</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Slide-over Product Dossier Drawer Component -->
        <div x-show="dossierOpen" 
             x-cloak 
             class="relative z-[110]" 
             role="dialog" 
             aria-modal="true"
             @keydown.escape.window="dossierOpen = false">

            <!-- Backdrop Blur Overlay -->
            <div x-show="dossierOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="dossierOpen = false"
                 class="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity">
            </div>

            <!-- Slide-over Drawer on Right Edge -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-6">
                        <div x-show="dossierOpen"
                             x-transition:enter="transform transition ease-out duration-300"
                             x-transition:enter-start="translate-x-full"
                             x-transition:enter-end="translate-x-0"
                             x-transition:leave="transform transition ease-in duration-200"
                             x-transition:leave-start="translate-x-0"
                             x-transition:leave-end="translate-x-full"
                             class="pointer-events-auto fixed inset-y-0 right-0 max-w-md w-full bg-[#051C15] border-l border-emerald-500/20 text-white z-[110] p-6 flex flex-col justify-between overflow-y-auto shadow-2xl">
                            
                            <!-- Drawer Top Section -->
                            <div>
                                <!-- Header & Close -->
                                <div class="flex items-center justify-between pb-4 border-b border-emerald-500/20">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                        <span class="text-[11px] font-mono uppercase tracking-[0.25em] text-amber-300 font-bold">Botanical Dossier</span>
                                    </div>
                                    <button type="button" 
                                            @click="dossierOpen = false" 
                                            class="w-8 h-8 rounded-full bg-white/[0.05] hover:bg-white/[0.12] border border-emerald-500/20 text-stone-300 hover:text-white flex items-center justify-center transition-all cursor-pointer"
                                            aria-label="Close Dossier">
                                        <i class="fa-solid fa-xmark text-sm"></i>
                                    </button>
                                </div>

                                <!-- Formulation Switcher Tabs -->
                                <div class="grid grid-cols-2 gap-2 mt-4 p-1 rounded-xl bg-black/40 border border-emerald-500/20">
                                    <button type="button" 
                                            @click="selectedProduct = 'honey'" 
                                            :class="selectedProduct === 'honey' ? 'bg-amber-400/20 border-amber-400/50 text-amber-300 shadow-sm' : 'text-stone-400 hover:text-white border-transparent'" 
                                            class="py-2 px-3 rounded-lg text-xs font-bold uppercase tracking-wider border transition-all text-center cursor-pointer">
                                        01 • Honey
                                    </button>
                                    <button type="button" 
                                            @click="selectedProduct = 'tonic'" 
                                            :class="selectedProduct === 'tonic' ? 'bg-emerald-400/20 border-emerald-400/50 text-emerald-300 shadow-sm' : 'text-stone-400 hover:text-white border-transparent'" 
                                            class="py-2 px-3 rounded-lg text-xs font-bold uppercase tracking-wider border transition-all text-center cursor-pointer">
                                        02 • Tonic
                                    </button>
                                </div>

                                <!-- Dynamic Product Hero Preview Card -->
                                <div class="mt-5 p-4 rounded-2xl bg-white/[0.03] border border-emerald-500/15 flex items-center gap-4">
                                    <div class="w-20 h-20 rounded-xl bg-emerald-950/60 border border-emerald-500/20 flex items-center justify-center p-2 shrink-0">
                                        <img :src="selectedProduct === 'honey' ? '{{ asset('uploads/products/Habibi-Honey.png') }}' : '{{ asset('uploads/products/habibi-tonic.png') }}'" 
                                             :alt="selectedProduct === 'honey' ? 'Habibi Natural Honey' : 'Habibi Herbal Tonic'" 
                                             class="h-full w-full object-contain">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] font-mono uppercase tracking-widest text-amber-400 font-bold block"
                                              x-text="selectedProduct === 'honey' ? '01 • Master Immunity Formula' : '02 • Cardiovascular Regimen'">
                                        </span>
                                        <h3 class="text-lg font-black uppercase tracking-tight text-white truncate"
                                            x-text="selectedProduct === 'honey' ? 'Habibi Natural Honey' : 'Habibi Herbal Tonic'">
                                        </h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-base font-black text-amber-400"
                                                  x-text="selectedProduct === 'honey' ? 'PKR 1,500' : 'PKR 1,200'">
                                            </span>
                                            <span class="text-xs text-emerald-200/50 line-through"
                                                  x-text="selectedProduct === 'honey' ? 'PKR 1,800' : 'PKR 1,500'">
                                            </span>
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/20"
                                                  x-text="selectedProduct === 'honey' ? '500g Jar' : '500ml Bottle'">
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clean 3-Pillar Apothecary Layout -->
                                <div class="mt-6 space-y-5 pb-8">
                                    
                                    <!-- Pillar A: Daily Health Benefits -->
                                    <div class="space-y-2.5">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-sparkles text-amber-400 text-xs"></i>
                                            <h4 class="text-xs uppercase tracking-[0.2em] text-emerald-200 font-bold">Daily Health Benefits</h4>
                                        </div>
                                        
                                        <!-- Honey Benefits List -->
                                        <template x-if="selectedProduct === 'honey'">
                                            <ul class="space-y-2.5 p-4 rounded-2xl bg-white/[0.02] border border-emerald-500/15">
                                                <li class="flex items-start gap-2.5 text-xs text-stone-200 leading-relaxed">
                                                    <span class="text-amber-400 font-bold text-sm shrink-0">✔</span>
                                                    <span>Sustained natural morning vitality without sugar spikes</span>
                                                </li>
                                                <li class="flex items-start gap-2.5 text-xs text-stone-200 leading-relaxed">
                                                    <span class="text-amber-400 font-bold text-sm shrink-0">✔</span>
                                                    <span>Soothes throat and reinforces upper respiratory immunity</span>
                                                </li>
                                                <li class="flex items-start gap-2.5 text-xs text-stone-200 leading-relaxed">
                                                    <span class="text-amber-400 font-bold text-sm shrink-0">✔</span>
                                                    <span>Rich in natural enzymes that aid gut digestion</span>
                                                </li>
                                            </ul>
                                        </template>

                                        <!-- Tonic Benefits List -->
                                        <template x-if="selectedProduct === 'tonic'">
                                            <ul class="space-y-2.5 p-4 rounded-2xl bg-white/[0.02] border border-emerald-500/15">
                                                <li class="flex items-start gap-2.5 text-xs text-stone-200 leading-relaxed">
                                                    <span class="text-amber-400 font-bold text-sm shrink-0">✔</span>
                                                    <span>Promotes smooth arterial blood flow & blood pressure balance</span>
                                                </li>
                                                <li class="flex items-start gap-2.5 text-xs text-stone-200 leading-relaxed">
                                                    <span class="text-amber-400 font-bold text-sm shrink-0">✔</span>
                                                    <span>Supports healthy cholesterol & metabolic detox</span>
                                                </li>
                                                <li class="flex items-start gap-2.5 text-xs text-stone-200 leading-relaxed">
                                                    <span class="text-amber-400 font-bold text-sm shrink-0">✔</span>
                                                    <span>Natural morning digestion booster with ginger & raw ACV</span>
                                                </li>
                                            </ul>
                                        </template>
                                    </div>

                                    <!-- Pillar B: Pure Botanical Ingredients -->
                                    <div class="space-y-2.5">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-seedling text-amber-400 text-xs"></i>
                                            <h4 class="text-xs uppercase tracking-[0.2em] text-emerald-200 font-bold">Pure Botanical Ingredients</h4>
                                        </div>
                                        <div class="p-4 rounded-2xl bg-white/[0.02] border border-emerald-500/15">
                                            <template x-if="selectedProduct === 'honey'">
                                                <p class="text-xs text-stone-300 leading-relaxed">
                                                    100% Raw, Unheated Sidr Flower Honey from wild mountain hives. Zero added sugars or syrups.
                                                </p>
                                            </template>
                                            <template x-if="selectedProduct === 'tonic'">
                                                <p class="text-xs text-stone-300 leading-relaxed">
                                                    Synergistic brew of 5 whole ingredients: Cold-pressed Ginger, Garlic, Lemon, Apple Cider Vinegar (with mother), and raw Sidr Honey.
                                                </p>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Pillar C: How to Use (The Daily Ritual) -->
                                    <div class="space-y-2.5">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-mortar-pestle text-amber-400 text-xs"></i>
                                            <h4 class="text-xs uppercase tracking-[0.2em] text-emerald-200 font-bold">How to Use <span class="text-emerald-400/60 font-serif italic lowercase font-normal">(the daily ritual)</span></h4>
                                        </div>
                                        <div class="p-4 rounded-2xl bg-white/[0.02] border border-emerald-500/15">
                                            <template x-if="selectedProduct === 'honey'">
                                                <p class="text-xs text-stone-300 leading-relaxed">
                                                    Take 1 tablespoon every morning on an empty stomach, or mix into lukewarm herbal tea.
                                                </p>
                                            </template>
                                            <template x-if="selectedProduct === 'tonic'">
                                                <p class="text-xs text-stone-300 leading-relaxed">
                                                    Dilute 1–2 tablespoons in a glass of warm water and drink 15 minutes before breakfast.
                                                </p>
                                            </template>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Sticky Checkout Bar at Drawer Footer -->
                            <div class="sticky bottom-0 -mx-6 -mb-6 p-5 bg-[#031710]/95 backdrop-blur-md border-t border-emerald-500/20 z-20">
                                <div class="flex items-center justify-between gap-4">
                                    <!-- Quantity Selector -->
                                    <div class="flex items-center bg-black/40 border border-emerald-500/20 rounded-xl p-1">
                                        <button type="button" 
                                                @click="if(quantity > 1) quantity--" 
                                                class="w-8 h-8 rounded-lg bg-white/[0.05] hover:bg-white/[0.12] text-stone-300 hover:text-white flex items-center justify-center transition-colors cursor-pointer"
                                                aria-label="Decrease quantity">
                                            <i class="fa-solid fa-minus text-[10px]"></i>
                                        </button>
                                        <span class="w-9 text-center font-bold text-sm text-white" x-text="quantity">1</span>
                                        <button type="button" 
                                                @click="quantity++" 
                                                class="w-8 h-8 rounded-lg bg-white/[0.05] hover:bg-white/[0.12] text-stone-300 hover:text-white flex items-center justify-center transition-colors cursor-pointer"
                                                aria-label="Increase quantity">
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                        </button>
                                    </div>

                                    <!-- Price Display -->
                                    <div class="text-right">
                                        <span class="text-[10px] uppercase tracking-wider text-emerald-300/70 block">Total Price</span>
                                        <span class="text-xl font-black text-amber-400 tracking-tight" x-text="totalPriceFormatted">PKR 1,500</span>
                                    </div>
                                </div>

                                <!-- Proceed to Checkout Button -->
                                <button type="button" 
                                        @click="addToBagFromDrawer()" 
                                        class="w-full mt-3 py-3.5 px-5 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 hover:from-amber-400 hover:to-amber-300 text-slate-950 font-black text-xs uppercase tracking-widest shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50 hover:scale-[1.01] active:scale-99 transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    <i class="fa-solid fa-bag-shopping text-xs"></i>
                                    <span>Proceed to Checkout</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Broadcasters & Media Anchors Video Reviews Carousel -->
    <section class="py-24 bg-[#031710] text-white relative overflow-hidden border-t border-emerald-500/10" id="customer-video-reviews" x-data="{
        canScrollLeft: false,
        canScrollRight: true,
        updateScrollState() {
            const el = this.$refs.carousel;
            if (!el) return;
            this.canScrollLeft = el.scrollLeft > 10;
            this.canScrollRight = el.scrollLeft + el.clientWidth < el.scrollWidth - 10;
        },
        scroll(direction) {
            const el = this.$refs.carousel;
            if (!el) return;
            const scrollAmount = direction === 'left' ? -340 : 340;
            el.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }" x-init="$nextTick(() => updateScrollState())">
        
        <!-- Ambient Botanical Glows with Soft Horizontal Emerald Wash -->
        <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1100px] h-[380px] bg-emerald-500/10 rounded-full blur-[140px]"></div>
        <div class="pointer-events-none absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-0 right-10 w-96 h-96 bg-amber-400/10 rounded-full blur-3xl"></div>

        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <!-- Header with Title, Subtitle, and Nav Controls -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-14">
                <div class="space-y-3 max-w-2xl">
                    <span class="text-xs uppercase tracking-[0.28em] text-amber-300 font-serif italic block">
                        ✦ Respected Broadcasters & Everyday Wellness
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white mt-2">
                        TRUSTED BY NATIONWIDE VOICES
                    </h2>
                    <p class="text-sm sm:text-base text-emerald-100/70 max-w-2xl mt-2 leading-relaxed">
                        Leading Pakistani media figures and broadcast journalists share their authentic daily experiences with MediTrade Global botanicals.
                    </p>
                </div>

                <!-- Navigation Controls for Desktop/Tablet -->
                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-1.5 text-xs text-emerald-200/50 font-semibold mr-2 font-mono uppercase tracking-wider">
                        <i class="fa-solid fa-arrows-left-right text-amber-400"></i>
                        <span>Swipe to explore</span>
                    </div>
                    <button type="button" 
                            @click="scroll('left')" 
                            :disabled="!canScrollLeft"
                            class="w-11 h-11 rounded-full border border-emerald-500/20 bg-white/[0.04] hover:bg-white/[0.12] text-emerald-200 flex items-center justify-center transition-all disabled:opacity-30 disabled:cursor-not-allowed cursor-pointer active:scale-95 shadow-sm"
                            aria-label="Previous media review">
                        <i class="fa-solid fa-arrow-left-long text-sm"></i>
                    </button>
                    <button type="button" 
                            @click="scroll('right')" 
                            :disabled="!canScrollRight"
                            class="w-11 h-11 rounded-full border border-emerald-500/20 bg-white/[0.04] hover:bg-white/[0.12] text-emerald-200 flex items-center justify-center transition-all disabled:opacity-30 disabled:cursor-not-allowed cursor-pointer active:scale-95 shadow-sm"
                            aria-label="Next media review">
                        <i class="fa-solid fa-arrow-right-long text-sm"></i>
                    </button>
                </div>
            </div>

            @php
                $videoReviews = [
                    [
                        'name' => 'Kiraan Aftaab',
                        'role' => 'Television Host & Broadcast Journalist',
                        'video' => 'uploads/videos/Kiraan Aftaab.mp4',
                    ],
                    [
                        'name' => 'Manzar Rizvi',
                        'role' => 'Senior Journalist & Media Analyst',
                        'video' => 'uploads/videos/Manzar Rizvi.mp4',
                    ],
                    [
                        'name' => 'Sana Haroon',
                        'role' => 'News Anchor & Television Presenter',
                        'video' => 'uploads/videos/Sana Haroon.mp4',
                    ],
                    [
                        'name' => 'Bushra Haq',
                        'role' => 'Senior News Anchor & Broadcast Journalist',
                        'video' => 'uploads/videos/Bushra Haq.mp4',
                    ],
                    [
                        'name' => 'Khatija Rathore',
                        'role' => 'Current Affairs Anchor & Television Host',
                        'video' => 'uploads/videos/Khadija Rathore.mp4',
                    ],
                    [
                        'name' => 'Aamir Shaikh',
                        'role' => 'Veteran Journalist & Media Controller',
                        'video' => 'uploads/videos/Aamir Sheikh.mp4',
                    ],
                    [
                        'name' => 'Mrs. Azhar',
                        'role' => 'Long-Term Daily Wellness User',
                        'video' => 'uploads/videos/MRS Azhar.mp4',
                    ],
                ];
            @endphp

            <!-- Horizontal Snap-Scroll Media Reel Track -->
            <div x-ref="carousel" 
                 @scroll.debounce.50ms="updateScrollState()" 
                 class="flex gap-6 overflow-x-auto pb-6 pt-2 snap-x snap-mandatory scroll-smooth [&::-webkit-scrollbar]:hidden"
                 style="scrollbar-width: none; -ms-overflow-style: none;">
                @foreach($videoReviews as $index => $review)
                <div x-data="{ 
                         isPlaying: false, 
                         togglePlay() { 
                             const v = this.$refs.video; 
                             if (!v) return;
                             if (v.paused) { 
                                 v.play(); 
                                 this.isPlaying = true; 
                             } else { 
                                 v.pause(); 
                                 this.isPlaying = false; 
                             } 
                         } 
                     }"
                     @click="togglePlay()"
                     class="relative rounded-3xl overflow-hidden aspect-[9/16] bg-stone-900 border border-emerald-500/15 group cursor-pointer shadow-2xl flex-none w-[270px] sm:w-[300px] snap-start select-none">
                    
                    <!-- 9:16 Vertical Video without Native Controls -->
                    <video x-ref="video" 
                           @play="isPlaying = true" 
                           @pause="isPlaying = false" 
                           @ended="isPlaying = false" 
                           playsinline 
                           preload="metadata" 
                           class="w-full h-full object-cover">
                        <source src="{{ asset($review['video']) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <!-- Center Play Trigger (Floating circular frosted button) -->
                    <div x-show="!isPlaying" 
                         x-transition.opacity.duration.200ms
                         class="absolute inset-0 flex items-center justify-center pointer-events-none z-20">
                        <div class="w-16 h-16 rounded-full bg-black/55 backdrop-blur-md border border-amber-400/40 text-amber-300 flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:border-amber-300 group-hover:bg-black/70 transition-all duration-300">
                            <i class="fa-solid fa-play text-xl ml-1 text-amber-300 drop-shadow-md"></i>
                        </div>
                    </div>

                    <!-- Bottom Gradient Shade & Media Profile Info -->
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-stone-950 via-stone-950/85 to-transparent px-5 pt-16 pb-4 sm:pb-5 flex flex-col justify-end z-20">
                        <!-- 5 Gold Stars (★★★★★) -->
                        <div class="flex items-center gap-1 text-amber-400 text-xs mb-1.5">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <!-- Anchor/Journalist Name -->
                        <h3 class="text-sm font-bold uppercase text-white leading-tight tracking-wide group-hover:text-amber-300 transition-colors">
                            {{ $review['name'] }}
                        </h3>

                        <!-- Professional Role -->
                        <p class="text-xs text-amber-300 font-medium mt-0.5 line-clamp-1">
                            {{ $review['role'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Us / Heritage & Standards Section -->
    <section id="about" class="py-24 bg-[#031710] text-white relative overflow-hidden border-t border-emerald-500/10">
      <!-- Subtle background ambient glows with Warm Golden Aura for Accreditation -->
      <div class="pointer-events-none absolute -top-32 right-1/4 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-[140px]"></div>
      <div class="pointer-events-none absolute bottom-10 left-10 w-[600px] h-[450px] bg-amber-400/10 rounded-full blur-[140px]"></div>
      <div class="pointer-events-none absolute bottom-0 right-10 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl"></div>

      <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
          <span class="text-xs uppercase tracking-[0.28em] text-amber-300 font-serif italic">
            ✦ A Decade of Pure Botanical Care
          </span>
          <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white mt-3">
            GLOBAL STANDARDS. NATURAL SOLUTIONS.
          </h2>
          <p class="text-sm sm:text-base text-emerald-100/70 mt-3 leading-relaxed">
            What began over ten years ago with our first handcrafted bottle of Habibi Herbal Tonic has grown into a trusted national standard for pure, lab-certified wellness.
          </p>
        </div>

        <!-- Split Heritage Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
          
          <!-- Left Narrative Card -->
          <div class="lg:col-span-7 rounded-3xl bg-white/[0.03] border border-emerald-500/15 p-8 sm:p-10 flex flex-col justify-between backdrop-blur-sm">
            <div>
              <span class="text-xs uppercase tracking-widest text-emerald-400 font-mono font-bold">Our Journey</span>
              <h3 class="text-2xl sm:text-3xl font-serif italic text-white mt-2 mb-4">
                Herbal Care for Every Pakistani Home
              </h3>
              <p class="text-emerald-100/80 text-sm sm:text-base leading-relaxed mb-4">
                Our mission is to make herbal remedies a trusted household essential—as dependable and accessible as the medicines families keep within arm’s reach. We started with a simple belief: combining time-tested natural botanicals with uncompromised manufacturing integrity.
              </p>
              <p class="text-emerald-100/70 text-sm leading-relaxed">
                From our flagship five-ingredient tonic studied across universities in Pakistan to wild raw honey, our formulations are crafted to empower daily cardiovascular flow, metabolic cleanse, and natural vitality.
              </p>
            </div>

            <!-- 3 Trust Badges -->
            <div class="grid grid-cols-3 gap-3 pt-8 mt-8 border-t border-emerald-500/15">
              <div class="p-3 rounded-2xl bg-white/[0.02] border border-emerald-500/10 text-center">
                <span class="block text-amber-400 font-bold text-base sm:text-lg">DRAP</span>
                <span class="block text-[10px] uppercase tracking-wider text-emerald-200/70 mt-0.5">Approved</span>
              </div>
              <div class="p-3 rounded-2xl bg-white/[0.02] border border-emerald-500/10 text-center">
                <span class="block text-amber-400 font-bold text-base sm:text-lg">GMP</span>
                <span class="block text-[10px] uppercase tracking-wider text-emerald-200/70 mt-0.5">Certified Plant</span>
              </div>
              <div class="p-3 rounded-2xl bg-white/[0.02] border border-emerald-500/10 text-center">
                <span class="block text-amber-400 font-bold text-base sm:text-lg">ISO</span>
                <span class="block text-[10px] uppercase tracking-wider text-emerald-200/70 mt-0.5">Quality Standard</span>
              </div>
            </div>
          </div>

          <!-- Right Feature Pillars -->
          <div class="lg:col-span-5 flex flex-col gap-4 justify-between">
            
            <div class="p-6 rounded-3xl bg-white/[0.03] border border-emerald-500/15 backdrop-blur-sm">
              <div class="w-8 h-8 rounded-full bg-amber-400/10 flex items-center justify-center text-amber-400 text-sm font-bold mb-3">01</div>
              <h4 class="text-base font-bold text-white uppercase tracking-wide">Strict Raw Selection</h4>
              <p class="text-xs sm:text-sm text-emerald-100/70 mt-1.5 leading-relaxed">
                Pure cold-pressed ginger, mountain garlic, unheated Sidr honey, and natural mother vinegar—zero synthetic dilution or refined sugar.
              </p>
            </div>

            <div class="p-6 rounded-3xl bg-white/[0.03] border border-emerald-500/15 backdrop-blur-sm">
              <div class="w-8 h-8 rounded-full bg-amber-400/10 flex items-center justify-center text-amber-400 text-sm font-bold mb-3">02</div>
              <h4 class="text-base font-bold text-white uppercase tracking-wide">University Validated</h4>
              <p class="text-xs sm:text-sm text-emerald-100/70 mt-1.5 leading-relaxed">
                Formulation ingredients evaluated for cardiovascular and metabolic balance across university research environments in Pakistan.
              </p>
            </div>

            <div class="p-6 rounded-3xl bg-white/[0.03] border border-emerald-500/15 backdrop-blur-sm">
              <div class="w-8 h-8 rounded-full bg-amber-400/10 flex items-center justify-center text-amber-400 text-sm font-bold mb-3">03</div>
              <h4 class="text-base font-bold text-white uppercase tracking-wide">Expanding Horizons</h4>
              <p class="text-xs sm:text-sm text-emerald-100/70 mt-1.5 leading-relaxed">
                Expanding from our signature tonic into single-origin vinegars, moringa wellness powders, and pure botanical concentrates.
              </p>
            </div>

          </div>

        </div>

      </div>
    </section>

    <!-- The Botanical Dispatch Newsletter Banner -->
    <section class="py-20 bg-gradient-to-b from-[#031710] to-[#062419] px-4 sm:px-6 relative overflow-hidden border-t border-emerald-500/10">
        <div class="max-w-6xl mx-auto rounded-[2.5rem] bg-gradient-to-br from-[#0a3826]/90 via-[#06291c]/80 to-[#031c13]/90 border border-emerald-400/25 p-8 sm:p-14 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)] relative overflow-hidden backdrop-blur-xl">
            <!-- Subtle honey-amber glow inside the card on the right behind the button -->
            <div class="pointer-events-none absolute -right-16 -top-16 w-64 h-64 bg-amber-400/15 rounded-full blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-20 -left-20 w-64 h-64 bg-emerald-500/15 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="space-y-2 text-center lg:text-left">
                    <span class="text-xs uppercase tracking-[0.25em] text-amber-300 font-serif italic block">✦ Pure Living &amp; Harvest Notes</span>
                    <h3 class="text-2xl sm:text-4xl font-black uppercase tracking-tight text-white mt-1">THE BOTANICAL DISPATCH</h3>
                    <p class="text-xs sm:text-sm text-emerald-100/70 max-w-md mt-2">
                        Receive physician-reviewed natural wellness guides, unheated Sidr harvest updates, and subscriber-only remedy reserves.
                    </p>
                </div>
                <div class="w-full lg:max-w-md">
                    <form action="{{ route('newsletter.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <input type="email" 
                               name="email" 
                               placeholder="Enter your email address" 
                               required
                               class="flex-1 bg-white/[0.06] border border-emerald-500/30 text-white placeholder-emerald-100/40 rounded-full px-5 py-3.5 text-sm focus:outline-none focus:border-amber-400">
                        <button type="submit" 
                                class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-stone-950 font-bold px-7 py-3.5 rounded-full text-xs uppercase tracking-wider shadow-[0_4px_20px_rgba(245,158,11,0.35)] transition-all shrink-0 cursor-pointer">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
