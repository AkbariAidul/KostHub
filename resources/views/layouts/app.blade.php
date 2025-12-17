<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- PENTING UNTUK AJAX -->
        <link href="{{ asset('assets/output.css') }}" rel="stylesheet">
        
        <!-- Google Font: Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        
        <!-- Tailwind Config Mockup (Jika belum di-compile, biar style jalan di preview ini) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'ngekos-black': '#0F172A',
                            'ngekos-grey': '#64748B',
                            'ngekos-orange': '#4FA8C0', // KITA GANTI ORANGE LAMA JADI TOSCA UTAMA
                        }
                    }
                }
            }
        </script>
        <style>
            body { font-family: 'Poppins', sans-serif; background-color: #FAFAFA; }
            .hide-scrollbar::-webkit-scrollbar { display: none; }
            .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body>
        <!-- Mobile Container Wrapper -->
        <div id="Content-Container" class="relative flex flex-col w-full max-w-[640px] min-h-screen mx-auto bg-white shadow-xl overflow-x-hidden">
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="{{ asset ('assets/js/index.js') }}"></script>
        @yield('scripts')
    </body>
</html>