@extends('layouts.app')

@section('content')
    <div class="relative w-full h-[320px] bg-slate-200">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-transparent z-10"></div>
        
        <div class="absolute top-6 left-0 right-0 px-6 flex items-center justify-between z-20">
            <a href="{{ url()->previous() }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 backdrop-blur-md hover:bg-white transition-all text-white hover:text-slate-800 border border-white/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div class="flex gap-3">
                
                <button onclick="toggleSave('{{ $boardingHouse->slug }}', this)" class="save-btn w-10 h-10 flex items-center justify-center rounded-full bg-white/20 backdrop-blur-md hover:bg-white transition-all text-white hover:text-red-500 border border-white/20 group" data-slug="{{ $boardingHouse->slug }}">
                    <svg class="w-5 h-5 heart-icon transition-transform group-active:scale-125" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                </button>
            </div>
        </div>

        <div class="swiper-gallery w-full h-full">
            <div class="swiper-wrapper">
                @foreach ($boardingHouse->rooms as $room)
                    @foreach ($room->images as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <main class="relative -mt-10 bg-white rounded-t-[40px] px-6 pt-8 pb-32 z-10 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] min-h-screen">
        
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="font-bold text-2xl text-slate-800 leading-tight mb-1">{{ $boardingHouse->name }}</h1>
                <div class="flex items-center gap-1.5 text-slate-400 text-sm">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    {{ $boardingHouse->city->name }}
                </div>
            </div>
            <div class="flex flex-col items-end">
                <div class="flex items-center gap-1 bg-orange-50 px-2.5 py-1 rounded-full border border-orange-100">
                    <svg class="w-4 h-4 text-orange-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span class="font-bold text-sm text-orange-600">4.8</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 bg-slate-50">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Kategori</p>
                    <p class="text-xs font-bold text-slate-700 truncate">{{ $boardingHouse->category->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 bg-slate-50">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Kapasitas</p>
                    <p class="text-xs font-bold text-slate-700">Max 2 Orang</p>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h2 class="font-bold text-lg text-slate-800 mb-3">Tentang Kos</h2>
            <div class="text-slate-500 text-sm leading-relaxed text-justify space-y-2">
                {!! $boardingHouse->description !!}
            </div>
        </div>

        <div class="mb-24">
            <div class="flex gap-6 border-b border-slate-100 mb-5 pb-1 overflow-x-auto hide-scrollbar">
                <button class="tab-link pb-3 font-bold text-primary border-b-2 border-primary transition-all whitespace-nowrap" data-target-tab="#Bonus-Tab">Fasilitas</button>
                <button class="tab-link pb-3 font-medium text-slate-400 hover:text-primary transition-all whitespace-nowrap" data-target-tab="#Testimonials-Tab">Review</button>
            </div>

            <div id="TabsContent">
                <div id="Bonus-Tab" class="tab-content flex flex-col gap-4">
                    @foreach ($boardingHouse->bonuses as $bonus)
                        <div class="flex items-center gap-4 p-4 rounded-[20px] bg-white border border-slate-100 shadow-sm hover:border-primary/30 transition-all">
                            <div class="w-16 h-16 rounded-xl bg-slate-100 overflow-hidden shrink-0">
                                <img src="{{ asset('storage/' . $bonus->image) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">{{ $bonus->name }}</h4>
                                <p class="text-xs text-slate-500 leading-tight">{{ $bonus->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div id="Testimonials-Tab" class="tab-content hidden flex-col gap-4">
                    @foreach ($boardingHouse->testimonials as $testi)
                        <div class="p-5 rounded-[20px] bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3 mb-3">
                                <img src="{{ asset('storage/' . $testi->photo) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                <div>
                                    <p class="font-bold text-sm text-slate-800">{{ $testi->name }}</p>
                                    <div class="flex text-orange-400 text-[10px]">
                                        @for($i=0; $i<$testi->rating; $i++) 
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 italic leading-relaxed">"{{ $testi->content }}"</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </main>

    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-full max-w-[480px] px-6 z-50">
        <div class="bg-[#1E293B] rounded-full p-1.5 pl-6 flex items-center justify-between shadow-2xl shadow-slate-900/30 border border-slate-800">
            <div class="flex flex-col justify-center">
                <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">Mulai dari</span>
                <span class="font-bold text-white text-lg">Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}<span class="text-slate-500 font-normal text-xs ml-1">/bln</span></span>
            </div>
            <a href="{{ route('kos.rooms', $boardingHouse->slug) }}" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-full font-bold text-sm transition-all shadow-lg shadow-primary/20 active:scale-95 flex items-center gap-2">
                Pilih Kamar
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Init Swiper for Image Gallery
        if (document.querySelector('.swiper-gallery')) {
            new Swiper('.swiper-gallery', {
                slidesPerView: 1,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
            });
        }

        const tabLinks = document.querySelectorAll('.tab-link');
        tabLinks.forEach(button => {
            button.addEventListener('click', () => {
                // Reset Styles
                tabLinks.forEach(btn => {
                    btn.classList.remove('text-primary', 'border-b-2', 'border-primary', 'font-bold');
                    btn.classList.add('text-slate-400', 'font-medium', 'border-transparent');
                });
                // Active Style
                button.classList.add('text-primary', 'border-b-2', 'border-primary', 'font-bold');
                button.classList.remove('text-slate-400', 'font-medium', 'border-transparent');

                // Toggle Content
                const target = button.getAttribute('data-target-tab');
                document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
                document.querySelector(target).classList.remove('hidden');
            });
        });
    </script>
@endsection