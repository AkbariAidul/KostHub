@extends('layouts.app')

@section('content')
    <div class="px-6 mt-10 mb-6 flex items-center justify-between">
        <a href="{{ route('find-kos') }}" class="w-10 h-10 bg-white border border-slate-100 rounded-full flex items-center justify-center shadow-sm hover:bg-slate-50">
            <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <h1 class="font-bold text-lg text-slate-800">Hasil Pencarian</h1>
        <div class="w-10"></div>
    </div>

    <div class="px-6 mb-6">
        <div class="bg-[#4FA8C0] rounded-[24px] p-6 text-white shadow-lg shadow-[#4FA8C0]/20 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-white/80 text-sm">Ditemukan</p>
                <h2 class="text-3xl font-bold">{{ $boardingHouses->count() }} <span class="text-lg font-medium">Kos Tersedia</span></h2>
            </div>
            <div class="absolute -right-6 -bottom-10 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
        </div>
    </div>

    <section class="flex flex-col gap-4 px-6 pb-32">
        @forelse ($boardingHouses as $house)
            <a href="{{ route('kos.show', $house->slug) }}" class="block">
                <div class="bg-white rounded-[24px] p-3 border border-slate-100 shadow-sm hover:shadow-md hover:border-[#4FA8C0]/30 transition-all flex gap-4 items-center">
                    
                    <div class="w-[100px] h-[100px] shrink-0 rounded-2xl bg-slate-100 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $house->thumbnail) }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black/50 backdrop-blur-sm p-1 flex justify-center">
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-[10px] font-bold text-white">4.8</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 py-1">
                        <h3 class="font-bold text-slate-800 text-base line-clamp-1 mb-1">{{ $house->name }}</h3>
                        
                        <div class="flex items-center gap-1 text-xs text-slate-400 mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            {{ $house->city->name }}
                        </div>

                        <div class="flex items-center gap-1 text-xs text-slate-400 mb-2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            {{ $house->rooms->count() }} Tipe Kamar
                        </div>

                        <p class="font-bold text-[#4FA8C0] text-sm">
                            Rp {{ number_format($house->price, 0, ',', '.') }}
                            <span class="text-slate-400 font-normal text-[10px]">/bln</span>
                        </p>
                    </div>
                </div>
            </a>
        @empty
            <div class="flex flex-col items-center justify-center mt-10 opacity-50">
                <svg class="w-16 h-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="mt-4 font-semibold text-slate-500">Belum ada kos ditemukan</p>
            </div>
        @endforelse
    </section>
@endsection