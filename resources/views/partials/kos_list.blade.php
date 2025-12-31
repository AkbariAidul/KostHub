@forelse ($houses as $house)
<div class="relative group block bg-white rounded-[24px] p-3 border border-slate-100 shadow-sm hover:shadow-lg transition-all active:scale-[0.98]">
    
    <button onclick="event.preventDefault(); toggleSave('{{ $house->slug }}', this)" 
            class="save-btn absolute top-5 right-5 z-20 w-8 h-8 rounded-full bg-white/40 backdrop-blur-md flex items-center justify-center transition-all hover:bg-red-50 hover:text-red-500 text-white shadow-sm border border-white/50"
            data-slug="{{ $house->slug }}">
        <svg class="w-5 h-5 heart-icon transition-transform active:scale-125" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>

    <a href="{{ route('kos.show', $house->slug) }}" class="flex gap-4">
        <div class="relative w-28 h-28 rounded-2xl overflow-hidden shrink-0 bg-slate-100">
            <img src="{{ asset('storage/' . $house->thumbnail) }}" class="w-full h-full object-cover">
            <div class="absolute top-2 left-2 bg-white/90 backdrop-blur px-1.5 py-0.5 rounded-md flex items-center gap-0.5 shadow-sm">
                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="text-[10px] font-bold text-slate-800">4.8</span>
            </div>
        </div>
        
        <div class="flex flex-col justify-between flex-1 py-1">
            <div>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">{{ $house->category->name }}</span>
                <h3 class="font-bold text-slate-800 text-base leading-tight mb-1 line-clamp-2">{{ $house->name }}</h3>
                <div class="flex items-center gap-1 text-slate-400 text-xs">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    {{ $house->city->name }}
                </div>
            </div>
            <div class="flex items-center justify-between mt-2">
                <p class="font-extrabold text-[#4FA8C0] text-base">
                    Rp {{ number_format($house->price / 1000, 0) }}rb<span class="text-slate-400 font-medium text-[10px]">/bln</span>
                </p>
            </div>
        </div>
    </a>
</div>
@empty
@endforelse