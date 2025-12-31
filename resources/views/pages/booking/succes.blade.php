@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center px-6 text-center bg-white relative overflow-hidden">
        <div class="absolute top-[-20%] left-0 w-full h-[500px] bg-gradient-to-b from-[#4FA8C0]/10 to-transparent rounded-b-full -z-10"></div>

        <div class="w-24 h-24 bg-[#4FA8C0] rounded-full flex items-center justify-center shadow-xl shadow-[#4FA8C0]/30 mb-8 animate-bounce">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" /></svg>
        </div>

        <h1 class="font-black text-3xl text-slate-800 mb-2">Horee! Berhasil! 🎉</h1>
        <p class="text-slate-400 text-sm mb-10 leading-relaxed max-w-[250px]">
            Pembayaran kamu berhasil dikonfirmasi. Kamarmu sudah siap ditempati.
        </p>

        <div class="w-full bg-slate-50 border border-slate-100 rounded-[24px] p-4 flex items-center gap-4 mb-10 text-left shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-white overflow-hidden shrink-0 border border-slate-200">
                <img src="{{ asset('storage/' . $transaction->boardingHouse->thumbnail) }}" class="w-full h-full object-cover">
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-sm">{{ $transaction->boardingHouse->name }}</h3>
                <p class="text-xs text-slate-400 mt-1">Kode Booking:</p>
                <p class="text-sm font-mono font-bold text-[#4FA8C0]">{{ $transaction->code }}</p>
            </div>
        </div>

        <div class="w-full flex flex-col gap-3">
            <form action="{{ route('check-booking.show') }}" method="POST" class="w-full">
                @csrf
                <input type="hidden" name="code" value="{{ $transaction->code }}">
                <input type="hidden" name="email" value="{{ $transaction->email }}">
                <input type="hidden" name="phone_number" value="{{ $transaction->phone_number }}">
                <button type="submit" class="w-full py-4 bg-[#1E293B] text-white rounded-full font-bold shadow-lg shadow-slate-900/20 hover:shadow-slate-900/30 transition-all">
                    Lihat Detail Booking
                </button>
            </form>
            
            <a href="{{ route('home') }}" class="w-full py-4 text-slate-400 font-bold hover:text-slate-600 transition-all">
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection