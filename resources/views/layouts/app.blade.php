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
                        fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                        colors: {
                            'primary': '#4FA8C0',
                            'primary-dark': '#3A8B9F',
                            'dark': '#0F172A',
                            'soft-bg': '#F8FAFC',
                        },
                        boxShadow: {
                            'nav': '0 10px 40px -10px rgba(15, 23, 42, 0.1)',
                            'card': '0 4px 20px -5px rgba(0, 0, 0, 0.03)',
                        }
                    }
                }
            }
        </script>
        
        <style>
            body { background-color: #F6F8FD; color: #1E293B; }
            .hide-scrollbar::-webkit-scrollbar { display: none; }
            .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
            html { scroll-behavior: smooth; }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased">
        <div id="Content-Container" class="relative min-h-screen w-full max-w-[480px] mx-auto bg-white shadow-2xl overflow-x-hidden pb-[140px]">
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

        @filamentScripts
        @vite('resources/js/app.js')
        @yield('scripts')

        <script>
            function toggleSave(slug, btn) {
                // Ambil data array dari Local Storage
                let saved = JSON.parse(localStorage.getItem('saved_kos')) || [];
                
                const index = saved.indexOf(slug);
                const icon = btn.querySelector('.heart-icon');

                if (index === -1) {
                    // Simpan
                    saved.push(slug);
                    
                    icon.setAttribute('fill', 'currentColor');
                    icon.classList.add('text-red-500');
                    btn.classList.add('text-red-500', 'bg-red-50', 'border-red-200');
                    btn.classList.remove('text-white', 'bg-white/40', 'bg-white/60');
                } else {
                    // Hapus
                    saved.splice(index, 1);
                    
                    icon.setAttribute('fill', 'none');
                    icon.classList.remove('text-red-500');
                    btn.classList.remove('text-red-500', 'bg-red-50', 'border-red-200');
                    btn.classList.add('text-white', 'bg-white/60'); // Default style
                    
                    // Khusus di halaman Saved, hapus elemen
                    if (window.location.pathname.includes('/saved')) {
                        const card = btn.closest('.group');
                        if (card) card.remove();
                        if (saved.length === 0) location.reload();
                    }
                }

                localStorage.setItem('saved_kos', JSON.stringify(saved));
            }

            // Init State on Load
            document.addEventListener('DOMContentLoaded', () => {
                const saved = JSON.parse(localStorage.getItem('saved_kos')) || [];
                
                document.querySelectorAll('.save-btn').forEach(btn => {
                    if (saved.includes(btn.dataset.slug)) {
                        const icon = btn.querySelector('.heart-icon');
                        icon.setAttribute('fill', 'currentColor');
                        icon.classList.add('text-red-500');
                        btn.classList.add('text-red-500', 'bg-red-50', 'border-red-200');
                        btn.classList.remove('text-white', 'bg-white/40', 'bg-white/60');
                    }
                });
            });
        </script>
    </body>
</html>