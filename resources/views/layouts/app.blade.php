<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ \App\Models\Setting::getValue('site_name', config('app.name', 'Gohar Herbal Care')) }} | Management Console</title>
        @if(\App\Models\Setting::getValue('site_favicon'))
            <link rel="icon" href="{{ \App\Models\Setting::getValue('site_favicon') }}">
        @endif
        <meta name="description" content="Manage your herbal care business with our premium management console.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        <style>
            html { font-size: 92%; }
            body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; background-color: #f0fdf4; }
            [x-cloak] { display: none !important; }
            /* Herbal scrollbar */
            ::-webkit-scrollbar { width: 5px; height: 5px; }
            ::-webkit-scrollbar-track { background: #f0fdf4; }
            ::-webkit-scrollbar-thumb { background: #86efac; border-radius: 8px; }
            ::-webkit-scrollbar-thumb:hover { background: #15803d; }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased" style="background-color: #f0fdf4;" x-data="{ sidebarOpen: false }">
        @include('partials.toast')
        
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            @if(Auth::check() && Auth::user()->hasRole('admin'))
                @include('layouts.sidebar')
            @endif

            <!-- Main Content Area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden" style="background-color: #f0fdf4;">
                <!-- Top Navigation -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-emerald-100 z-30">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Main Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        <x-back-to-top />
    </body>
</html>
