<div id="BottomNav" class="fixed bottom-6 w-full max-w-[640px] px-5 z-50">
    <nav class="bg-[#0F172A] rounded-[30px] p-[14px_24px] shadow-[0_10px_30px_0_rgba(15,23,42,0.25)]">
        <div class="flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex flex-col items-center text-center gap-1 group">
                <!-- Icon Home -->
                <svg class="w-6 h-6 {{ request()->routeIs('home') ? 'text-[#4FA8C0]' : 'text-slate-500 group-hover:text-white' }} transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="text-[10px] font-semibold {{ request()->routeIs('home') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}">Discover</span>
            </a>
            
            <a href="{{ route('check-booking') }}" class="flex flex-col items-center text-center gap-1 group">
                <!-- Icon Orders -->
                <svg class="w-6 h-6 {{ request()->routeIs('check-booking') ? 'text-[#4FA8C0]' : 'text-slate-500 group-hover:text-white' }} transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <span class="text-[10px] font-semibold {{ request()->routeIs('check-booking') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}">Orders</span>
            </a>

            <a href="{{ route('find-kos') }}" class="flex flex-col items-ce nter text-center gap-1 group">
                <!-- Icon Find -->
                <svg class="w-6 h-6 {{ request()->routeIs('find-kos') ? 'text-[#4FA8C0]' : 'text-slate-500 group-hover:text-white' }} transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <span class="text-[10px] font-semibold {{ request()->routeIs('find-kos') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}">Find</span>
            </a>

            <a href="#" class="flex flex-col items-center text-center gap-1 group">
                <!-- Icon Help -->
                <svg class="w-6 h-6 text-slate-500 group-hover:text-white transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                <span class="text-[10px] font-semibold text-slate-500 group-hover:text-white">Help</span>
            </a>
        </div>
    </nav>
</div>