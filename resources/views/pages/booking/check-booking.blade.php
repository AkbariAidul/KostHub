@extends('layouts.app')

@section('content')
    <div class="relative bg-gradient-to-b from-[#E3F4F6] to-[#F8FAFC] pb-16 px-6 pt-12 rounded-b-[40px]">
        <div class="text-center">
            <h1 class="font-extrabold text-2xl text-slate-900 leading-tight">Cek Status<br>Pesanan</h1>
            <p class="text-slate-500 text-sm mt-2">Lacak booking kosmu dengan mudah.</p>
        </div>
    </div>

    <div class="px-6 -mt-10 pb-10"> 
        <form action="{{ route('check-booking.show') }}" method="POST" class="bg-white rounded-[32px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 flex flex-col gap-5">
            @csrf
            
            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-800 text-sm">Kode Booking</label>
                <div class="flex items-center w-full rounded-2xl px-4 py-3.5 bg-[#F8FAFC] border border-slate-200 focus-within:border-[#4FA8C0] focus-within:ring-2 focus-within:ring-[#4FA8C0]/20 transition-all">
                    <img src="{{ asset('assets/images/icons/note-favorite-grey.svg') }}" class="w-6 h-6 opacity-40">
                    <input type="text" name="code" value="{{ old('code') }}" class="w-full ml-3 bg-transparent outline-none font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-medium" placeholder="Contoh: KSTHB8821">
                </div>
                @error('code') <p class="text-red-500 text-xs font-semibold pl-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-800 text-sm">Alamat Email</label>
                <div class="flex items-center w-full rounded-2xl px-4 py-3.5 bg-[#F8FAFC] border border-slate-200 focus-within:border-[#4FA8C0] focus-within:ring-2 focus-within:ring-[#4FA8C0]/20 transition-all">
                    <img src="{{ asset('assets/images/icons/sms.svg') }}" class="w-6 h-6 opacity-40">
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full ml-3 bg-transparent outline-none font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-medium" placeholder="Email terdaftar">
                </div>
                @error('email') <p class="text-red-500 text-xs font-semibold pl-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-800 text-sm">Nomor Handphone</label>
                <div class="flex items-center w-full rounded-2xl px-4 py-3.5 bg-[#F8FAFC] border border-slate-200 focus-within:border-[#4FA8C0] focus-within:ring-2 focus-within:ring-[#4FA8C0]/20 transition-all">
                    <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-6 h-6 opacity-40">
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}" class="w-full ml-3 bg-transparent outline-none font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-medium" placeholder="08xxxxxxxxxx">
                </div>
                @error('phone_number') <p class="text-red-500 text-xs font-semibold pl-1">{{ $message }}</p> @enderror
            </div>

            @if (session('error'))
                <div class="bg-red-50 text-red-500 text-xs font-bold p-3 rounded-xl text-center border border-red-100">
                    {{ session('error') }}
                </div>
            @endif

            <hr class="border-slate-100 my-2">

            <button type="submit" class="w-full rounded-full py-4 bg-[#4FA8C0] hover:bg-[#3d8b9f] font-extrabold text-white text-base shadow-lg shadow-[#4FA8C0]/20 transition-all active:scale-95">
                Lihat Pesanan Saya
            </button>
        </form>
    </div>

    @include('includes.navigation')
@endsection