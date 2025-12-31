@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#F8FAFC] pb-10">
        <div class="px-6 pt-10 pb-6 flex items-center gap-4 bg-white shadow-sm sticky top-0 z-30">
            <a href="{{ route('check-booking') }}" class="w-10 h-10 border border-slate-100 rounded-full flex items-center justify-center text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h1 class="font-bold text-lg text-slate-800">Detail Booking</h1>
        </div>

        <div class="px-6 mt-6">
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-slate-100 mb-6 text-center">
                @if($transaction->payment_status == 'success' || $transaction->payment_status == 'paid')
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h2 class="font-bold text-xl text-slate-800">Booking Berhasil!</h2>
                    <p class="text-sm text-slate-400 mt-1">Pembayaran telah dikonfirmasi.</p>
                @elseif($transaction->payment_status == 'pending')
                    <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h2 class="font-bold text-xl text-slate-800">Menunggu Pembayaran</h2>
                    <p class="text-sm text-slate-400 mt-1">Segera selesaikan pembayaranmu.</p>
                @else
                    <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                    </div>
                    <h2 class="font-bold text-xl text-slate-800">Booking Gagal/Batal</h2>
                @endif
                
                <div class="mt-4 inline-block bg-slate-50 px-4 py-2 rounded-full border border-slate-100">
                    <span class="text-xs font-bold text-slate-500">ID: {{ $transaction->code }}</span>
                </div>
            </div>

            <div class="bg-white rounded-[24px] overflow-hidden shadow-sm border border-slate-100 mb-6">
                <div class="p-4 bg-slate-50 flex items-center gap-4 border-b border-slate-100">
                    <div class="w-16 h-16 rounded-xl bg-white overflow-hidden shrink-0 border border-slate-200">
                        <img src="{{ asset('storage/' . $transaction->boardingHouse->thumbnail) }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $transaction->boardingHouse->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $transaction->room->name }}</p>
                    </div>
                </div>

                <div class="p-5 flex flex-col gap-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400">Nama Pemesan</span>
                        <span class="font-bold text-slate-700">{{ $transaction->name }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400">Durasi</span>
                        <span class="font-bold text-slate-700">{{ $transaction->duration }} Bulan</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400">Check-in</span>
                        <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($transaction->start_date)->format('d M Y') }}</span>
                    </div>
                    
                    <div class="h-px bg-slate-100 border-dashed border-t border-slate-200 my-1"></div>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400">Total Bayar</span>
                        <span class="font-bold text-[#4FA8C0] text-lg">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <a href="https://wa.me/6281234567890" target="_blank" class="flex w-full justify-center rounded-full py-4 bg-[#1E293B] font-bold text-white shadow-lg hover:shadow-xl transition-all">
                Hubungi Admin / Bantuan
            </a>
            
            <a href="{{ route('home') }}" class="block text-center mt-4 text-sm font-bold text-slate-400 hover:text-slate-600">
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection