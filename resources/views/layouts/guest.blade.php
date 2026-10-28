<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ \App\Models\Setting::getValue('site_name', config('app.name', 'Gohar Herbal Care')) }} | Secure Access</title>
    @if(\App\Models\Setting::getValue('site_favicon'))
        <link rel="icon" href="{{ \App\Models\Setting::getValue('site_favicon') }}">
    @endif
    
    <!-- Premium Font Integration -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 400: '#4ade80',
                            500: '#22c55e', 600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d', 950: '#052e16'
                        },
                        secondary: {
                            50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a', 300: '#fcd34d', 400: '#fbbf24',
                            500: '#f59e0b', 600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f'
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        html {
            min-height: 100%;
            overflow-y: auto;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #022c22;
            background-image: 
                radial-gradient(at 0% 0%, rgba(21, 128, 61, 0.3) 0, transparent 50%), 
                radial-gradient(at 50% 0%, rgba(5, 46, 22, 0.8) 0, transparent 50%), 
                radial-gradient(at 100% 0%, rgba(2, 44, 34, 0.9) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(217, 119, 6, 0.1) 0, transparent 40%);
            margin: 0; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            overflow-y: auto !important;
            overflow-x: hidden;
        }
        /* Botanical leaf texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url('https://www.transparenttextures.com/patterns/leaf.png');
            opacity: 0.04;
            pointer-events: none;
        }
        [x-cloak] { display: none !important; }
        
        .master-container {
            width: 100%;
            max-width: 1000px;
            background: rgba(5, 46, 22, 0.7);
            border: 1px solid rgba(134, 239, 172, 0.1);
            border-radius: 2rem;
            display: flex;
            overflow: hidden;
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(134,239,172,0.05);
            backdrop-filter: blur(20px);
            position: relative;
            z-index: 10;
            margin: auto;
        }

        .left-panel {
            width: 40%;
            background: linear-gradient(160deg, #052e16 0%, #14532d 50%, #15803d 100%);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(134, 239, 172, 0.1);
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(217, 119, 6, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(134, 239, 172, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .right-panel {
            width: 60%;
            background: rgba(2, 44, 34, 0.8);
            display: flex;
            flex-direction: column;
            padding: 2.5rem;
        }

        .input-dark {
            background-color: rgba(5, 46, 22, 0.6) !important;
            border: 1px solid rgba(134, 239, 172, 0.15) !important;
            color: #F8FAFC !important;
            padding: 0.75rem 1rem 0.75rem 2.75rem !important;
            border-radius: 0.75rem !important;
            width: 100% !important;
            font-size: 0.813rem !important;
            transition: all 0.3s ease;
        }

        .input-dark:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #052e16 inset !important;
            -webkit-text-fill-color: #F8FAFC !important;
        }

        .input-dark:focus {
            border-color: rgba(134, 239, 172, 0.4) !important;
            background-color: rgba(5, 46, 22, 0.8) !important;
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.15) !important;
            outline: none !important;
        }

        .input-dark::placeholder { color: rgba(134, 239, 172, 0.3); }

        .input-icon {
            color: rgba(134, 239, 172, 0.4);
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.875rem;
            pointer-events: none;
        }
        .group:focus-within .input-icon { color: #86efac; }

        .label-text {
            color: rgba(134, 239, 172, 0.7);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.4rem;
            display: block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #15803d, #d97706);
            color: #FFF;
            padding: 0.875rem;
            border-radius: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            width: 100%;
            font-size: 0.813rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 30px -5px rgba(21, 128, 61, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -5px rgba(21, 128, 61, 0.5);
            filter: brightness(1.1);
        }
        .btn-primary:active { transform: translateY(0); }

        @keyframes float-leaf {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.6; }
            50% { transform: translateY(-20px) rotate(10deg); opacity: 0.8; }
        }
        .float-leaf { animation: float-leaf 6s ease-in-out infinite; }

        @media (max-width: 900px) {
            body {
                align-items: flex-start !important;
                padding: 1rem 0.5rem !important;
            }
            .master-container { 
                flex-direction: column; 
                max-width: 100%; 
                border-radius: 1.5rem;
                margin: 0 auto;
            }
            .left-panel, .right-panel { 
                width: 100%; 
                padding: 1.5rem 1.25rem; 
            }
            .left-panel { 
                border-right: none; 
                border-bottom: 1px solid rgba(134, 239, 172, 0.1); 
            }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Floating botanical elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-20 left-10 text-emerald-600/10 text-8xl float-leaf" style="animation-delay: 0s;">🌿</div>
        <div class="absolute bottom-20 right-10 text-emerald-700/10 text-6xl float-leaf" style="animation-delay: 2s;">🌱</div>
        <div class="absolute top-1/2 left-1/4 text-amber-600/5 text-9xl float-leaf" style="animation-delay: 4s;">🍃</div>
    </div>

    <div class="master-container">
        <!-- Left Section -->
        <div class="left-panel">
            <div class="relative z-10">
                <div class="mb-4 sm:mb-8">
                    <a href="/">
                        @php $logoSrc = \App\Models\Setting::getValue('site_logo'); @endphp
                        @if($logoSrc)
                            <img src="{{ mediaUrl($logoSrc) }}" alt="{{ \App\Models\Setting::getValue('site_name', 'Gohar Herbal Care') }}" class="h-10 sm:h-12 w-auto object-contain" />
                        @else
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-tr from-emerald-600 to-amber-500 rounded-2xl flex items-center justify-center shadow-xl shadow-emerald-900/40">
                                    <i class="fa-solid fa-leaf text-white text-lg sm:text-xl"></i>
                                </div>
                                <span class="font-black text-xl sm:text-2xl text-white tracking-tighter">{{ \App\Models\Setting::getValue('site_name', 'Gohar Herbal') }}</span>
                            </div>
                        @endif
                    </a>
                </div>
                
                <div class="space-y-2 mb-4 sm:mb-6">
                    <div class="inline-flex items-center gap-2 bg-emerald-800/40 px-3 py-1.5 rounded-full border border-emerald-600/30">
                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                        <span class="text-[9px] font-black text-emerald-300 uppercase tracking-[0.3em]">100% Pure Organic</span>
                    </div>
                </div>

                <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight tracking-tighter">
                    Natural <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-amber-300">Herbal Care</span> <br/>
                    Management.
                </h1>
                <p class="text-emerald-200/60 text-xs sm:text-sm mt-2 sm:mt-4 font-medium leading-relaxed">
                    {{ \App\Models\Setting::getValue('site_tagline', 'Manage your organic herbal care business with precision and excellence.') }}
                </p>

                <!-- Feature badges -->
                <div class="mt-4 sm:mt-8 space-y-3 hidden sm:block">
                    @foreach([
                        ['fa-leaf', 'Pure Botanical Sourcing'],
                        ['fa-shield-halved', 'Secure Platform'],
                        ['fa-seedling', 'Certified Organic'],
                    ] as [$icon, $label])
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-800/50 border border-emerald-700/30 flex items-center justify-center">
                            <i class="fa-solid {{ $icon }} text-emerald-400 text-[10px]"></i>
                        </div>
                        <span class="text-emerald-200/70 text-[11px] font-black uppercase tracking-widest">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 sm:pt-6 border-t border-emerald-800/30 relative z-10 hidden sm:flex">
                <div class="flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-[9px]"></i>
                    <span class="text-emerald-300/70 text-[8.5px] font-black uppercase tracking-[0.1em]">99.9% Uptime</span>
                </div>
                <div class="w-px h-2.5 bg-emerald-800/50"></div>
                <div class="flex items-center gap-1.5">
                    <i class="fa-solid fa-lock text-amber-400 text-[9px]"></i>
                    <span class="text-emerald-300/70 text-[8.5px] font-black uppercase tracking-[0.1em]">SSL Secured</span>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-panel">
            {{ $slot }}
        </div>
    </div>

    @include('partials.toast')
</body>
</html>
