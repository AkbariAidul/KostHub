<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ config('app.name') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        },
                        colors: {
                            'primary': '#4FA8C0', // Tosca Utama
                            'primary-dark': '#3A8B9F',
                            'dark': '#0F172A',
                            'soft-bg': '#F6F8FD', // Background abu kebiruan sangat muda
                        },
                        boxShadow: {
                            'nav': '0 10px 40px -10px rgba(79, 168, 192, 0.3)',
                            'card': '0 10px 30px -10px rgba(0, 0, 0, 0.05)',
                        }
                    }
                }
            }
        </script>
        
        <style>
            body { background-color: #F6F8FD; }
            .hide-scrollbar::-webkit-scrollbar { display: none; }
            .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
            /* Smooth scrolling */
            html { scroll-behavior: smooth; }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased text-slate-800">
        <div id="Content-Container" class="relative min-h-screen w-full max-w-[640px] mx-auto bg-white shadow-2xl overflow-x-hidden pb-[140px]">
            @yield('content')
        </div>

        @filamentScripts
        @vite('resources/js/app.js')
        
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="{{ asset ('assets/js/index.js') }}"></script>
        @yield('scripts')
    </body>
</html>