@extends('layouts.app')

@section('content')
    <div class="px-6 mt-10 mb-6 flex items-center gap-4">
        <a href="{{ url()->previous() }}" class="w-10 h-10 bg-white border border-slate-100 rounded-full flex items-center justify-center shadow-sm text-slate-600 hover:text-slate-800 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <h1 class="font-bold text-lg text-slate-800">Isi Data Diri</h1>
    </div>

    <div class="px-6 mb-8">
        <div class="bg-white p-4 rounded-[24px] border border-slate-100 shadow-sm flex gap-4 items-center">
            <div class="w-[90px] h-[80px] rounded-2xl bg-slate-100 overflow-hidden shrink-0">
                <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col gap-1 w-full">
                <h2 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $boardingHouse->name }}</h2>
                <div class="flex items-center gap-1 text-xs text-slate-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    {{ $boardingHouse->city->name }}
                </div>
                <div class="h-px bg-slate-100 w-full my-1"></div>
                <p class="text-xs font-bold text-[#4FA8C0]">{{ $room->name }} <span class="text-slate-400 font-normal">• {{ $room->capacity }} Orang</span></p>
            </div>
        </div>
    </div>

    <form action="{{ route('booking.information.save', $boardingHouse->slug) }}" method="POST" class="bg-white rounded-t-[40px] px-6 pt-8 pb-32 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] border-t border-slate-100 min-h-screen">
        @csrf
        
        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-1">
                <h2 class="font-bold text-lg text-slate-800">Informasi Pemesan</h2>
                <p class="text-xs text-slate-400">Pastikan data yang kamu isi valid ya.</p>
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-700 text-sm">Nama Lengkap</label>
                <div class="flex items-center w-full rounded-full px-5 py-3.5 bg-slate-50 border border-slate-200 focus-within:border-[#4FA8C0] focus-within:ring-1 focus-within:ring-[#4FA8C0] transition-all">
                    <img src="{{ asset('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 opacity-40">
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full ml-3 bg-transparent outline-none font-semibold text-slate-700 placeholder:text-slate-400 placeholder:font-normal text-sm" placeholder="Nama sesuai KTP">
                </div>
                @error('name') <p class="text-red-500 text-xs pl-2">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-700 text-sm">Email Address</label>
                <div class="flex items-center w-full rounded-full px-5 py-3.5 bg-slate-50 border border-slate-200 focus-within:border-[#4FA8C0] focus-within:ring-1 focus-within:ring-[#4FA8C0] transition-all">
                    <img src="{{ asset('assets/images/icons/sms.svg') }}" class="w-5 h-5 opacity-40">
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full ml-3 bg-transparent outline-none font-semibold text-slate-700 placeholder:text-slate-400 placeholder:font-normal text-sm" placeholder="kamu@example.com">
                </div>
                @error('email') <p class="text-red-500 text-xs pl-2">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-bold text-slate-700 text-sm">Nomor HP (WhatsApp)</label>
                <div class="flex items-center w-full rounded-full px-5 py-3.5 bg-slate-50 border border-slate-200 focus-within:border-[#4FA8C0] focus-within:ring-1 focus-within:ring-[#4FA8C0] transition-all">
                    <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-5 h-5 opacity-40">
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}" class="w-full ml-3 bg-transparent outline-none font-semibold text-slate-700 placeholder:text-slate-400 placeholder:font-normal text-sm" placeholder="08xxxxxxxxxx">
                </div>
                @error('phone_number') <p class="text-red-500 text-xs pl-2">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label class="font-bold text-slate-700 text-sm">Durasi (Bulan)</label>
                    <div class="flex items-center w-full rounded-full px-5 py-3.5 bg-slate-50 border border-slate-200 relative">
                        <button type="button" id="Minus" class="w-6 h-6 flex items-center justify-center text-slate-400 hover:text-[#4FA8C0]">-</button>
                        <input id="Duration" type="number" name="duration" value="1" class="w-full text-center bg-transparent outline-none font-bold text-slate-800" min="1" readonly>
                        <button type="button" id="Plus" class="w-6 h-6 flex items-center justify-center text-slate-400 hover:text-[#4FA8C0]">+</button>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-bold text-slate-700 text-sm">Tanggal Mulai</label>
                    <div class="flex items-center w-full rounded-full px-5 py-3.5 bg-slate-50 border border-slate-200">
                        <input type="date" name="start_date" class="w-full bg-transparent outline-none font-semibold text-slate-700 text-sm" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-6 left-0 right-0 px-6 z-50">
            <div class="bg-[#1E293B] rounded-[28px] p-4 pl-6 flex items-center justify-between shadow-2xl">
                <div class="flex flex-col">
                    <span class="text-xs text-slate-400 font-medium">Total Sementara</span>
                    <span class="font-bold text-white text-lg" id="priceDisplay">Rp {{ number_format($room->price_per_month, 0, ',', '.') }}</span>
                </div>
                <button type="submit" class="bg-[#4FA8C0] text-white px-6 py-3 rounded-full font-bold text-sm hover:bg-[#3d8b9f] transition-all shadow-lg shadow-[#4FA8C0]/20">
                    Lanjut Bayar
                </button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        const defaultPrice = {{ $room->price_per_month }};
        const durationInput = document.getElementById('Duration');
        const priceDisplay = document.getElementById('priceDisplay');
        const minusBtn = document.getElementById('Minus');
        const plusBtn = document.getElementById('Plus');

        function formatRupiah(number) {
            return 'Rp ' + number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updatePrice() {
            let duration = parseInt(durationInput.value);
            let total = defaultPrice * duration;
            priceDisplay.innerText = formatRupiah(total);
        }

        plusBtn.addEventListener('click', () => {
            let val = parseInt(durationInput.value);
            durationInput.value = val + 1;
            updatePrice();
        });

        minusBtn.addEventListener('click', () => {
            let val = parseInt(durationInput.value);
            if(val > 1) {
                durationInput.value = val - 1;
                updatePrice();
            }
        });
    </script>
@endsection