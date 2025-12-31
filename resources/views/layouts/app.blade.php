<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ config('app.name') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                        colors: {
                            'primary': '#4FA8C0', // Warna Tosca Utama
                            'dark': '#0F172A',
                            'soft': '#F6F8FD',
                        },
                        boxShadow: {
                            'soft': '0 10px 40px -10px rgba(0,0,0,0.08)',
                        }
                    }
                }
            }
        </script>
        
        <style>
            body { background-color: #F6F8FD; color: #1E293B; }
            
            /* HILANGKAN SCROLLBAR TAPI TETAP BISA SCROLL */
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }
            
            html { scroll-behavior: smooth; }
        </style>
    </head>

    <body class="antialiased">
        <div id="Content-Container" class="relative min-h-screen w-full max-w-[480px] mx-auto bg-white shadow-2xl overflow-x-hidden pb-[140px]">
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        @yield('scripts')
        <script>
        // --- LOGIC SAVE / BOOKMARK ---
        function toggleSave(slug, btn) {
            // Ambil data array dari Local Storage
            let saved = JSON.parse(localStorage.getItem('saved_kos')) || [];
            
            const index = saved.indexOf(slug);
            const icon = btn.querySelector('.heart-icon');

            if (index === -1) {
                // Jika belum ada, tambahkan (Simpan)
                saved.push(slug);
                
                // Ubah tampilan jadi merah (Saved)
                icon.setAttribute('fill', 'currentColor');
                icon.classList.add('text-red-500');
                btn.classList.add('text-red-500', 'bg-red-50', 'border-red-200');
                btn.classList.remove('text-white', 'bg-white/40');
            } else {
                // Jika sudah ada, hapus (Unsave)
                saved.splice(index, 1);
                
                // Ubah tampilan jadi putih (Unsaved)
                icon.setAttribute('fill', 'none');
                icon.classList.remove('text-red-500');
                btn.classList.remove('text-red-500', 'bg-red-50', 'border-red-200');
                btn.classList.add('text-white', 'bg-white/40');
                
                // Khusus jika sedang di halaman Saved, hapus elemen kartunya
                if (window.location.pathname.includes('/saved')) {
                    btn.closest('.group').remove();
                    // Jika kosong setelah dihapus, reload untuk tampilkan empty state
                    if(saved.length === 0) location.reload();
                }
            }

            // Simpan kembali array terbaru ke Local Storage
            localStorage.setItem('saved_kos', JSON.stringify(saved));
        }

        // Cek status saat halaman dimuat (untuk menandai yang sudah disimpan)
        document.addEventListener('DOMContentLoaded', () => {
            const saved = JSON.parse(localStorage.getItem('saved_kos')) || [];
            
            document.querySelectorAll('.save-btn').forEach(btn => {
                if (saved.includes(btn.dataset.slug)) {
                    const icon = btn.querySelector('.heart-icon');
                    icon.setAttribute('fill', 'currentColor');
                    icon.classList.add('text-red-500');
                    btn.classList.add('text-red-500', 'bg-red-50', 'border-red-200');
                    btn.classList.remove('text-white', 'bg-white/40');
                }
            });
        });
    </script>
</body>
</html>
    </body>
</html>