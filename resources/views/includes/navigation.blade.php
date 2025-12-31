<div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-full max-w-[480px] px-6 z-50">
    <nav class="bg-white/90 backdrop-blur-lg border border-white/40 rounded-full px-2 py-3 shadow-nav flex justify-between items-center relative">
        
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 group w-14 transition-all {{ request()->routeIs('home') ? '' : 'opacity-50 hover:opacity-100' }}">
            <svg class="w-6 h-6 {{ request()->routeIs('home') ? 'text-primary fill-primary/20' : 'text-slate-600' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/> 
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span class="text-[9px] font-bold {{ request()->routeIs('home') ? 'text-primary' : 'text-slate-500' }}">Home</span>
        </a>

        <a href="{{ route('check-booking') }}" class="flex flex-col items-center gap-1 group w-14 transition-all {{ request()->routeIs('check-booking') ? '' : 'opacity-50 hover:opacity-100' }}">
            <svg class="w-6 h-6 {{ request()->routeIs('check-booking') ? 'text-primary fill-primary/20' : 'text-slate-600' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="text-[9px] font-bold {{ request()->routeIs('check-booking') ? 'text-primary' : 'text-slate-500' }}">Pesanan</span>
        </a>

        <div class="relative w-14 flex justify-center">
            <a href="{{ route('find-kos') }}" class="absolute -top-10 w-14 h-14 bg-primary rounded-full flex items-center justify-center text-white shadow-lg shadow-primary/40 border-[4px] border-[#F8FAFC] transition-transform hover:scale-105 active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </a>
        </div>

      <a href="{{ route('saved-kos') }}" class="flex flex-col items-center gap-1 group w-16 transition-all {{ request()->routeIs('saved-kos') ? '' : 'opacity-50 hover:opacity-100' }}">
    <svg class="w-6 h-6 {{ request()->routeIs('saved-kos') ? 'text-primary fill-primary/20' : 'text-slate-600' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    <span class="text-[9px] font-bold {{ request()->routeIs('saved-kos') ? 'text-primary' : 'text-slate-500' }}">Simpan</span>
</a>

<a href="{{ route('help') }}" class="flex flex-col items-center gap-1 group w-16 transition-all {{ request()->routeIs('help') ? '' : 'opacity-50 hover:opacity-100' }}">
    <svg class="w-6 h-6 {{ request()->routeIs('help') ? 'text-primary fill-primary/20' : 'text-slate-600' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
    </svg>
    <span class="text-[9px] font-bold {{ request()->routeIs('help') ? 'text-primary' : 'text-slate-500' }}">Bantuan</span>
</a>

    </nav>
</div>