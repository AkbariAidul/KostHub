@extends('layouts.app')

@section('content')
    <div class="absolute top-[-50px] right-[-50px] w-64 h-64 bg-[#4FA8C0]/10 rounded-full blur-3xl -z-10"></div>

    <div class="relative flex flex-col gap-8 px-6 pt-10 pb-[120px]">
        
        <div class="text-center mt-6">
            <h1 class="font-extrabold text-[32px] leading-tight text-slate-800">
                Temukan Kos <br> <span class="text-[#4FA8C0]">Impianmu</span>
            </h1>
            <p class="text-slate-400 mt-2 text-sm">Cari sesuai kebutuhan dan budgetmu</p>
        </div>

        <form action="{{ route('find-kos.results') }}" class="bg-white rounded-[32px] p-6 shadow-soft border border-slate-100 flex flex-col gap-6">
            
            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-700 text-sm">Nama Kos</label>
                <div class="flex items-center w-full rounded-2xl p-4 bg-slate-50 border border-slate-100 focus-within:border-[#4FA8C0] focus-within:ring-1 focus-within:ring-[#4FA8C0] transition-all">
                    <img src="{{ asset('assets/images/icons/note-favorite-grey.svg') }}" class="w-5 h-5 opacity-50" alt="icon">
                    <input type="text" name="search" class="w-full ml-3 bg-transparent outline-none font-semibold text-slate-700 placeholder:text-slate-400 placeholder:font-normal" placeholder="Ketik nama kos...">
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-700 text-sm">Pilih Kota</label>
                <div class="relative flex items-center w-full rounded-2xl p-4 bg-slate-50 border border-slate-100 focus-within:border-[#4FA8C0] transition-all">
                    <img src="{{ asset('assets/images/icons/location.svg') }}" class="w-5 h-5 opacity-50 absolute left-4" alt="icon">
                    <select name="city" class="w-full pl-8 bg-transparent outline-none font-semibold text-slate-700 appearance-none z-10">
                        <option value="" hidden>Pilih kota tujuan</option>
                        @foreach ($cities as $city)
                            <option value="{{$city->slug}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="w-5 h-5 opacity-50 absolute right-4" alt="icon">
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-700 text-sm">Kategori</label>
                <div class="relative flex items-center w-full rounded-2xl p-4 bg-slate-50 border border-slate-100 focus-within:border-[#4FA8C0] transition-all">
                    <img src="{{ asset('assets/images/icons/location.svg') }}" class="w-5 h-5 opacity-50 absolute left-4" alt="icon">
                    <select name="category" class="w-full pl-8 bg-transparent outline-none font-semibold text-slate-700 appearance-none z-10">
                        <option value="" hidden>Pilih kategori kos</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->slug}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="w-5 h-5 opacity-50 absolute right-4" alt="icon">
                </div>
            </div>

            <button type="submit" class="w-full rounded-full py-4 bg-[#4FA8C0] font-bold text-white text-base shadow-lg shadow-[#4FA8C0]/30 hover:shadow-[#4FA8C0]/50 transition-all mt-2">
                Eksplor Sekarang
            </button>
        </form>
    </div>

    @include('includes.navigation')
@endsection