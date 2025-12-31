@extends('layouts.app')

@section('content')
    <header class="bg-white sticky top-0 z-40 px-6 pt-10 pb-4 border-b border-slate-50 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <img src="{{ asset('assets/logos/logopng.png') }}" class="h-10 w-auto object-contain" alt="Logo">
            
            <button onclick="toggleNotification()" class="w-10 h-10 bg-white rounded-full flex items-center justify-center border border-slate-100 relative hover:bg-slate-50 transition-colors active:scale-95">
                <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if($promoCodes->count() > 0)
                    <span class="absolute top-2.5 right-3 w-2 h-2 bg-red-500 rounded-full border border-white animate-pulse"></span>
                @endif
            </button>
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" id="searchInput" placeholder="Cari kos, lokasi, daerah..." 
                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3.5 pl-12 pr-4 text-sm font-bold text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
        </div>
    </header>

    <div id="defaultView" class="fade-in">
        
        <div class="mt-6 px-6">
            <h3 class="font-bold text-base text-slate-800 mb-3">Kategori</h3>
            <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-2">
                <button onclick="filterByCategory('all')" class="category-btn flex flex-col items-center gap-2 min-w-[70px] group" data-slug="all">
                    <div class="w-[70px] h-[70px] rounded-[24px] bg-primary flex items-center justify-center shadow-lg shadow-primary/30 transition-all icon-box overflow-hidden">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H16a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H16a2 2 0 01-2-2v-2z"/></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-800 label-text">Semua</span>
                </button>

                @foreach ($categories as $category)
                <button onclick="filterByCategory('{{ $category->slug }}')" class="category-btn flex flex-col items-center gap-2 min-w-[70px] group" data-slug="{{ $category->slug }}">
                    <div class="w-[70px] h-[70px] rounded-[24px] bg-slate-100 border border-slate-100 flex items-center justify-center shadow-sm transition-all icon-box group-hover:border-primary/50 overflow-hidden relative">
                        <img src="{{ Storage::url($category->image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <span class="text-[11px] font-medium text-slate-500 label-text group-hover:text-primary transition-colors truncate w-full text-center">{{ $category->name }}</span>
                </button>
                @endforeach
            </div>
        </div>

        @if($promoCodes->count() > 0)
        <div class="mt-6 px-6">
            <div class="swiper w-full h-[130px] rounded-[24px] overflow-hidden shadow-sm border border-slate-100">
                <div class="swiper-wrapper">
                    @foreach($promoCodes as $promo)
                    <div class="swiper-slide relative bg-[#0F172A] cursor-pointer" onclick="copyPromo('{{ $promo->code }}')">
                        <img src="{{ Storage::url($promo->image) }}" class="absolute inset-0 w-full h-full object-cover opacity-50">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/40 to-transparent"></div>
                        <div class="relative z-10 h-full flex flex-col justify-center px-6">
                            <span class="bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-md w-fit mb-2">PROMO</span>
                            <h3 class="text-white font-bold text-lg leading-tight w-2/3 mb-2">{{ $promo->name }}</h3>
                            <div class="flex items-center gap-2 bg-white/20 backdrop-blur-md px-3 py-1 rounded-lg w-fit border border-white/10">
                                <span class="text-white text-xs font-mono font-bold">{{ $promo->code }}</span>
                                <svg class="w-3 h-3 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="mt-8 px-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg text-slate-800">Jelajahi Kota</h3>
            </div>
            <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-4 snap-x">
                @foreach ($cities as $city)
                <a href="{{ route('city.show', $city->slug) }}" class="relative w-[120px] h-[150px] shrink-0 rounded-[24px] overflow-hidden group shadow-md snap-start transition-transform hover:scale-105">
                    @if($city->image)
                        <img src="{{ Storage::url($city->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $city->name }}">
                    @else
                        <div class="w-full h-full bg-slate-200 flex items-center justify-center"><span class="text-xs text-slate-400">No Image</span></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-80 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 text-center">
                        <p class="text-white font-bold text-sm leading-tight drop-shadow-md">{{ $city->name }}</p>
                        <div class="w-6 h-1 bg-[#4FA8C0] rounded-full mx-auto mt-2 opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300"></div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="mt-4 px-6 pb-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-base text-slate-800" id="listTitle">Rekomendasi Pilihan</h3>
            </div>
            <div id="loading" class="hidden flex justify-center py-4">
                <div class="w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
            </div>
            <div id="kosContainer" class="flex flex-col gap-4">
                @include('partials.kos_list', ['houses' => $popularBoardingHouses])
            </div>
        </div>
    </div>

    <div id="searchView" class="hidden px-6 pt-4 pb-32 min-h-screen fade-in">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-base text-slate-800">Hasil Pencarian</h3>
            <button onclick="clearSearch()" class="text-xs font-bold text-red-500">Reset</button>
        </div>
        <div id="resultsContainer" class="flex flex-col gap-4"></div>
    </div>

    <div id="notificationModal" class="hidden fixed inset-0 z-50 flex items-end justify-center sm:items-center">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="toggleNotification()"></div>
        
        <div class="relative bg-white w-full max-w-[480px] rounded-t-[32px] sm:rounded-[32px] p-6 shadow-2xl transform transition-transform translate-y-full sm:translate-y-0 duration-300" id="modalPanel">
            <div class="flex justify-center mb-4">
                <div class="w-12 h-1.5 bg-slate-200 rounded-full"></div>
            </div>
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-slate-800">Info & Promo</h2>
                <button onclick="toggleNotification()" class="p-2 bg-slate-50 rounded-full hover:bg-slate-100">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="flex flex-col gap-4 max-h-[60vh] overflow-y-auto hide-scrollbar">
                @forelse($promoCodes as $promo)
                <div class="flex gap-4 p-4 rounded-2xl border border-slate-100 bg-white shadow-sm cursor-pointer hover:border-primary/50 transition-all" onclick="copyPromo('{{ $promo->code }}'); toggleNotification()">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center shrink-0 text-primary">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 text-sm">{{ $promo->name }}</h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode <span class="font-mono font-bold text-primary">{{ $promo->code }}</span> saat checkout.</p>
                    </div>
                    <div class="flex items-center">
                         <span class="text-xs font-bold text-primary bg-primary/5 px-3 py-1 rounded-full">Salin</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-slate-400 text-sm">Belum ada promo atau info baru.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @include('includes.navigation')
    
    <div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 bg-slate-800 text-white px-4 py-2 rounded-full text-xs font-bold opacity-0 transition-all z-[60] pointer-events-none">Kode disalin!</div>

@endsection

@section('scripts')
<script>
    if (document.querySelector('.swiper')) {
        new Swiper('.swiper', { slidesPerView: 1, loop: true, autoplay: { delay: 3000 } });
    }
    
    // Toggle Notification Modal
    function toggleNotification() {
        const modal = document.getElementById('notificationModal');
        const panel = document.getElementById('modalPanel');
        
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            // Animasi Slide Up
            setTimeout(() => {
                panel.classList.remove('translate-y-full');
            }, 10);
        } else {
            // Animasi Slide Down
            panel.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }

    // ... (Script Filter & Search tetap sama) ...
    let currentCategory = 'all';
    let timeout = null;
    const defaultView = document.getElementById('defaultView');
    const searchView = document.getElementById('searchView');
    const searchInput = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('resultsContainer');
    const kosContainer = document.getElementById('kosContainer');
    
    function filterByCategory(slug) {
        currentCategory = slug;
        document.querySelectorAll('.category-btn').forEach(btn => {
            const box = btn.querySelector('.icon-box');
            const txt = btn.querySelector('.label-text');
            if(btn.dataset.slug === slug) {
                box.classList.remove('bg-slate-100', 'border-slate-100');
                box.classList.add('bg-white', 'border-primary', 'ring-2', 'ring-primary/20');
                txt.classList.add('text-slate-800', 'font-bold');
                txt.classList.remove('text-slate-500');
                if(slug === 'all') {
                     box.classList.remove('bg-white');
                     box.classList.add('bg-primary');
                }
            } else {
                box.classList.add('bg-slate-100', 'border-slate-100');
                box.classList.remove('bg-white', 'border-primary', 'ring-2', 'ring-primary/20');
                txt.classList.remove('text-slate-800', 'font-bold');
                txt.classList.add('text-slate-500');
                if(slug === 'all') { 
                     box.classList.remove('bg-primary');
                     box.classList.add('bg-primary');
                }
            }
        });
        fetchData(false); 
    }

    searchInput.addEventListener('input', (e) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            const keyword = e.target.value;
            if(keyword.length > 0) {
                defaultView.classList.add('hidden');
                searchView.classList.remove('hidden');
                fetchData(true);
            } else {
                clearSearch();
            }
        }, 500);
    });

    function clearSearch() {
        searchInput.value = '';
        searchView.classList.add('hidden');
        defaultView.classList.remove('hidden');
    }

    function fetchData(isSearchMode) {
        const keyword = searchInput.value;
        const targetContainer = isSearchMode ? resultsContainer : kosContainer;
        targetContainer.style.opacity = '0.5';
        fetch(`{{ route('kos.search') }}?keyword=${keyword}&category=${currentCategory}`)
            .then(res => res.json())
            .then(data => { targetContainer.innerHTML = data.html; })
            .catch(err => console.error(err))
            .finally(() => { targetContainer.style.opacity = '1'; });
    }

    function copyPromo(code) {
        navigator.clipboard.writeText(code);
        const t = document.getElementById('toast');
        t.classList.remove('opacity-0', 'translate-y-2');
        setTimeout(() => t.classList.add('opacity-0', 'translate-y-2'), 2000);
    }
</script>
@endsection