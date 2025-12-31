@extends('layouts.app')

@section('content')
    <div class="px-6 py-6 mt-4">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url()->previous() }}" class="w-10 h-10 bg-white border border-slate-100 rounded-full flex items-center justify-center shadow-sm text-slate-600 hover:text-slate-800 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h1 class="font-bold text-lg text-slate-800">Pilih Tipe Kamar</h1>
        </div>

        <form action="{{ route('booking', $boardingHouse->slug) }}" class="flex flex-col gap-4 pb-32">
            <input type="hidden" name="boarding_house_id" value="{{$boardingHouse->id}}">
            
            @foreach ($boardingHouse->rooms as $room)
            <label class="relative cursor-pointer group">
                <input type="radio" name="room_id" value="{{ $room->id }}" class="peer sr-only" required>
                
                <div class="p-4 bg-white rounded-[24px] border border-slate-100 shadow-sm transition-all flex gap-4 
                            peer-checked:border-[#4FA8C0] peer-checked:ring-1 peer-checked:ring-[#4FA8C0] peer-checked:bg-[#4FA8C0]/5
                            peer-checked:[&_.indicator]:bg-[#4FA8C0] peer-checked:[&_.indicator]:border-[#4FA8C0] 
                            peer-checked:[&_.indicator-dot]:block">
                    
                    <div class="w-24 h-24 bg-slate-100 rounded-xl overflow-hidden shrink-0">
                        @if($room->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $room->images->first()->image) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://placehold.co/300x300?text=No+Image" class="w-full h-full object-cover opacity-50">
                        @endif
                    </div>

                    <div class="flex flex-col justify-center w-full">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-slate-800 text-base">{{ $room->name }}</h3>
                            
                            <div class="indicator w-5 h-5 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center transition-all">
                                <div class="indicator-dot w-2.5 h-2.5 rounded-full bg-white hidden"></div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="text-[10px] bg-slate-50 border border-slate-100 px-2 py-1 rounded-md text-slate-500 font-medium">{{ $room->square_feet }} sqft</span>
                            <span class="text-[10px] bg-slate-50 border border-slate-100 px-2 py-1 rounded-md text-slate-500 font-medium">{{ $room->capacity }} Org</span>
                        </div>

                        <p class="font-extrabold text-[#4FA8C0] text-sm mt-2">
                            Rp {{ number_format($room->price_per_month, 0, ',', '.') }}<span class="text-slate-400 font-normal text-[10px] ml-1">/bln</span>
                        </p>
                    </div>
                </div>
            </label>
            @endforeach

            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-full max-w-[480px] px-6 z-50">
                <button type="submit" class="w-full bg-[#4FA8C0] text-white py-3.5 rounded-full font-bold text-base shadow-xl shadow-[#4FA8C0]/30 hover:bg-[#3d8b9f] hover:shadow-[#4FA8C0]/50 transition-all active:scale-95">
                    Lanjut Booking
                </button>
            </div>
        </form>
    </div>
@endsection