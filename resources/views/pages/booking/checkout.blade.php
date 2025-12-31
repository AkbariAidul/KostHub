@extends('layouts.app')

@section('content')
    @php
        $isError = !isset($boardingHouse) || !isset($room);
        if (!$isError) {
            $duration = $transaction['duration'] ?? 1;
            $roomPrice = $room->price_per_month ?? 0;
            $startDate = isset($transaction['start_date']) ? \Carbon\Carbon::parse($transaction['start_date'])->isoFormat('D MMM YYYY') : '-';
        }
    @endphp

    @if($isError)
        <div class="flex flex-col items-center justify-center min-h-screen px-5 text-center gap-4">
            <p class="text-slate-500">Data tidak ditemukan.</p>
            <a href="{{ route('home') }}" class="px-6 py-3 bg-[#4FA8C0] text-white rounded-full">Kembali</a>
        </div>
    @else
        
        <div class="px-6 py-6 mt-4 pb-32">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ url()->previous() }}" class="w-10 h-10 bg-white border border-slate-100 rounded-full flex items-center justify-center shadow-sm text-slate-600 hover:text-slate-800 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <h1 class="font-bold text-lg text-slate-800">Konfirmasi Pembayaran</h1>
            </div>

            <form action="{{ route('booking.payment', $boardingHouse->slug) }}" method="POST" class="flex flex-col gap-6">
                @csrf
                
                <div class="bg-white p-4 rounded-[24px] border border-slate-100 shadow-sm flex gap-4 items-center">
                    <div class="w-20 h-20 rounded-2xl bg-slate-100 overflow-hidden shrink-0">
                        <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $boardingHouse->name }}</h2>
                        <p class="text-xs text-slate-500 mt-1">{{ $room->name }} • {{ $room->square_feet }} sqft</p>
                        <div class="flex items-center gap-1 mt-1 text-xs text-slate-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $boardingHouse->city->name }}
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-[24px] border border-slate-100 shadow-sm flex flex-col gap-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Mulai Kos</span>
                        <span class="font-semibold text-slate-800">{{ $startDate }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Durasi</span>
                        <span class="font-semibold text-slate-800">{{ $duration }} Bulan</span>
                    </div>
                    
                    <div class="h-px bg-slate-100 my-1"></div>

                    <div>
                        <label class="text-xs font-bold text-slate-700 mb-2 block">Kode Promo</label>
                        <div class="flex gap-2">
                            <input type="text" id="promoCodeInput" placeholder="Masukkan kode..." class="w-full px-4 py-2.5 rounded-full bg-slate-50 border border-slate-200 text-sm outline-none focus:border-[#4FA8C0] transition uppercase">
                            <button type="button" onclick="applyPromo()" class="bg-slate-800 text-white px-5 py-2.5 rounded-full text-xs font-bold hover:bg-slate-700 transition">Apply</button>
                        </div>
                        <p id="promoMessage" class="text-xs mt-2 font-medium hidden"></p>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="font-bold text-slate-800 text-sm">Metode Pembayaran</h3>
                    
                    <label class="group flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-200 has-[:checked]:border-[#4FA8C0] has-[:checked]:bg-[#4FA8C0]/5 transition cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center group-has-[:checked]:border-[#4FA8C0]">
                                <div class="w-2 h-2 rounded-full bg-[#4FA8C0] hidden group-has-[:checked]:block"></div>
                            </div>
                            <span class="font-semibold text-sm text-slate-700">Bayar Penuh (100%)</span>
                        </div>
                        <input type="radio" name="payment_method" value="full_payment" class="hidden" onchange="updatePrice('full')" checked>
                    </label>

                    <label class="group flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-200 has-[:checked]:border-[#4FA8C0] has-[:checked]:bg-[#4FA8C0]/5 transition cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center group-has-[:checked]:border-[#4FA8C0]">
                                <div class="w-2 h-2 rounded-full bg-[#4FA8C0] hidden group-has-[:checked]:block"></div>
                            </div>
                            <span class="font-semibold text-sm text-slate-700">Bayar DP (30%)</span>
                        </div>
                        <input type="radio" name="payment_method" value="down_payment" class="hidden" onchange="updatePrice('dp')">
                    </label>
                </div>

                <input type="hidden" name="discount_amount" id="inputDiscount" value="0">
                <input type="hidden" name="grand_total" id="inputGrandTotal" value="0">
                <input type="hidden" name="promo_code" id="inputPromoCode" value="">

                <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-full max-w-[480px] px-6 z-50">
                    <div class="bg-[#1E293B] rounded-full p-1.5 pl-6 flex items-center justify-between shadow-2xl shadow-slate-900/30 border border-slate-800">
                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">Total Bayar</span>
                            <span class="font-bold text-white text-lg" id="bottomTotalDisplay">Rp 0</span>
                        </div>
                        <button type="submit" class="bg-[#4FA8C0] hover:bg-[#3d8b9f] text-white px-6 py-3 rounded-full font-bold text-sm transition-all shadow-lg shadow-[#4FA8C0]/20 active:scale-95 flex items-center gap-2">
                            Bayar Sekarang
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection

@section('scripts')
    @if(!($isError ?? true))
    <script>
        // ... (Script JS tetap sama seperti sebelumnya) ...
        const pricePerMonth = Number('{{ $roomPrice }}');
        const duration = Number('{{ $duration }}'); 
        let paymentType = 'full'; 
        let currentDiscount = 0; 
        let promoType = null; 

        function formatRupiah(number) {
            return 'Rp ' + number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function calculateTotal() {
            let subTotal = pricePerMonth * duration;
            let ppn = subTotal * 0.11;
            let insurance = subTotal * 0.01;
            let totalBase = subTotal + ppn + insurance;

            let totalAfterType = totalBase;
            if (paymentType === 'dp') {
                totalAfterType = totalBase * 0.30; 
            }

            let discountValue = 0;
            if (promoType === 'fixed') {
                discountValue = currentDiscount;
            } else if (promoType === 'percentage') {
                discountValue = totalAfterType * (currentDiscount / 100);
            }

            let grandTotal = totalAfterType - discountValue;
            if (grandTotal < 0) grandTotal = 0;

            // Update Teks Total di Bawah
            document.getElementById('bottomTotalDisplay').innerText = formatRupiah(grandTotal);
            
            // Update Input Hidden
            document.getElementById('inputDiscount').value = discountValue;
            document.getElementById('inputGrandTotal').value = grandTotal;
        }

        function updatePrice(type) {
            paymentType = type;
            calculateTotal();
        }

        async function applyPromo() {
            const codeInput = document.getElementById('promoCodeInput');
            const messageEl = document.getElementById('promoMessage');
            const code = codeInput.value;

            if(!code) return;

            messageEl.innerText = "Memeriksa...";
            messageEl.classList.remove('hidden', 'text-red-500', 'text-green-500');
            messageEl.classList.add('text-slate-500');

            try {
                const response = await fetch('/api/promo-check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code: code })
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    promoType = result.data.type;
                    currentDiscount = result.data.discount_amount;
                    
                    messageEl.innerText = "Berhasil! " + result.message;
                    messageEl.classList.replace('text-slate-500', 'text-green-500');
                    document.getElementById('inputPromoCode').value = code;
                } else {
                    throw new Error(result.message || "Kode tidak valid.");
                }
            } catch (error) {
                promoType = null;
                currentDiscount = 0;
                document.getElementById('inputPromoCode').value = "";
                messageEl.innerText = error.message;
                messageEl.classList.replace('text-slate-500', 'text-red-500');
            }
            calculateTotal();
        }

        calculateTotal();
    </script>
    @endif
@endsection