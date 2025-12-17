@extends('layouts.app')

@section('content')
    @php
        // 1. CEK DATA UTAMA (Anti-Crash)
        // Jika variabel tidak dikirim dari controller, kita set null/default agar tidak error 500
        $boardingHouseData = isset($boardingHouse) ? $boardingHouse : null;
        $roomData = isset($room) ? $room : null;
        $transactionData = isset($transaction) ? $transaction : [];

        // 2. CEK APAKAH DATA PENTING ADA?
        // Jika data kamar/kos hilang (misal session habis), stop render konten & minta user ulangi
        $isError = !$boardingHouseData || !$roomData;
        
        // 3. SIAPKAN VARIABEL AMAN
        if (!$isError) {
            $duration = $transactionData['duration'] ?? 1;
            $roomPrice = $roomData->price_per_month ?? 0;
            $tenantName = $transactionData['name'] ?? 'N/A';
            $tenantEmail = $transactionData['email'] ?? 'N/A';
            $tenantPhone = $transactionData['phone_number'] ?? 'N/A';
            
            $startDate = isset($transactionData['start_date']) 
                ? \Carbon\Carbon::parse($transactionData['start_date'])->isoFormat('D MMM YYYY') 
                : '-';
        }
    @endphp

    <!-- JIKA DATA HILANG/ERROR -->
    @if($isError)
        <div class="flex flex-col items-center justify-center min-h-screen px-5 text-center gap-4">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center text-red-500 mb-2">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h1 class="font-bold text-xl text-slate-800">Data Booking Tidak Ditemukan</h1>
            <p class="text-sm text-gray-500">Sesi pemesanan Anda mungkin telah berakhir. Silakan pilih kamar ulang.</p>
            <a href="{{ route('home') }}" class="mt-4 px-6 py-3 bg-[#4FA8C0] text-white rounded-full font-bold text-sm">Kembali ke Home</a>
        </div>
    @else
        <!-- JIKA DATA AMAN, TAMPILKAN KONTEN -->
        
        <!-- Header Gradient -->
        <div class="absolute top-0 w-full h-[280px] bg-gradient-to-b from-[#4FA8C0] to-white -z-10 rounded-b-[50px]"></div>

        <!-- Top Navigation -->
        <div class="px-5 mt-10 mb-6 flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="w-10 h-10 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-[#4FA8C0] transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-white font-bold text-xl">Booking Confirmation</h1>
        </div>

        <!-- Main Content Form -->
        <form action="{{ route('booking.payment', $boardingHouseData->slug) }}" method="POST" class="px-5 flex flex-col gap-6 pb-32">
            @csrf
            
            <!-- 1. Card Info Kost -->
            <div class="bg-white p-4 rounded-[24px] shadow-[0_8px_30px_rgba(0,0,0,0.05)] border border-gray-100 flex gap-4 items-center">
                <div class="w-[100px] h-[90px] rounded-2xl bg-gray-200 overflow-hidden shrink-0">
                    <img src="{{ asset('storage/' . $boardingHouseData->thumbnail) }}" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <h2 class="font-bold text-slate-800 line-clamp-1 text-base">{{ $boardingHouseData->name }}</h2>
                    <p class="text-xs text-slate-500 font-medium">{{ $roomData->name }} • {{ $roomData->square_feet }} sqft</p>
                    <div class="flex items-center gap-1 mt-1">
                        <svg class="w-4 h-4 text-[#4FA8C0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-xs text-slate-500">{{ $boardingHouseData->city->name }}</span>
                    </div>
                </div>
            </div>

            <!-- 2. Informasi Penyewa -->
            <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100 flex flex-col gap-4">
                <h3 class="font-bold text-slate-800 text-base">Informasi Penyewa</h3>
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Nama</span>
                        <span class="font-semibold text-sm text-slate-800">{{ $tenantName }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Email</span>
                        <span class="font-semibold text-sm text-slate-800">{{ $tenantEmail }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">No. HP</span>
                        <span class="font-semibold text-sm text-slate-800">{{ $tenantPhone }}</span>
                    </div>
                </div>
            </div>

            <!-- 3. Detail Booking -->
            <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100 flex flex-col gap-4">
                <h3 class="font-bold text-slate-800 text-base">Detail Booking</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2 p-3 rounded-2xl border border-gray-100 bg-[#FAFAFA]">
                        <p class="text-xs text-gray-400 font-medium">Mulai Ngekos</p>
                        <p class="font-bold text-sm text-slate-800">{{ $startDate }}</p>
                    </div>
                    <div class="flex flex-col gap-2 p-3 rounded-2xl border border-gray-100 bg-[#FAFAFA]">
                        <p class="text-xs text-gray-400 font-medium">Durasi</p>
                        <p class="font-bold text-sm text-slate-800">{{ $duration }} Bulan</p>
                    </div>
                </div>
            </div>

            <!-- 4. Opsi Pembayaran -->
            <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100">
                <h3 class="font-bold text-slate-800 mb-4 text-base">Metode Pembayaran</h3>
                <div class="flex flex-col gap-3">
                    <label class="group flex items-center justify-between p-4 rounded-2xl border border-gray-200 has-[:checked]:border-[#4FA8C0] has-[:checked]:bg-[#4FA8C0]/5 transition cursor-pointer relative overflow-hidden">
                        <div class="flex items-center gap-3 z-10">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center group-has-[:checked]:border-[#4FA8C0] transition">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#4FA8C0] hidden group-has-[:checked]:block"></div>
                            </div>
                            <span class="font-semibold text-sm text-slate-700">Bayar Penuh (100%)</span>
                        </div>
                        <input type="radio" name="payment_method" value="full_payment" class="hidden" onchange="updatePrice('full')" checked>
                    </label>

                    <label class="group flex items-center justify-between p-4 rounded-2xl border border-gray-200 has-[:checked]:border-[#4FA8C0] has-[:checked]:bg-[#4FA8C0]/5 transition cursor-pointer relative overflow-hidden">
                        <div class="flex items-center gap-3 z-10">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center group-has-[:checked]:border-[#4FA8C0] transition">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#4FA8C0] hidden group-has-[:checked]:block"></div>
                            </div>
                            <span class="font-semibold text-sm text-slate-700">Bayar DP (30%)</span>
                        </div>
                        <input type="radio" name="payment_method" value="down_payment" class="hidden" onchange="updatePrice('dp')">
                    </label>
                </div>
            </div>

            <!-- 5. Input Kode Promo -->
            <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100">
                <h3 class="font-bold text-slate-800 mb-3 text-base">Punya Kode Promo?</h3>
                <div class="relative">
                    <input type="text" id="promoCodeInput" placeholder="Masukkan kode (contoh: MABA)" 
                        class="w-full pl-5 pr-24 py-3 rounded-full bg-gray-50 border border-gray-200 outline-none text-sm font-semibold focus:border-[#4FA8C0] focus:ring-1 focus:ring-[#4FA8C0] transition uppercase placeholder:normal-case">
                    <button type="button" onclick="applyPromo()" 
                        class="absolute right-1.5 top-1.5 bottom-1.5 bg-[#0F172A] text-white px-5 rounded-full font-bold text-xs hover:bg-slate-800 transition">
                        Apply
                    </button>
                </div>
                <p id="promoMessage" class="text-xs mt-2 font-medium hidden"></p>
            </div>

            <!-- 6. Rincian Biaya -->
            <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100 flex flex-col gap-3">
                <h3 class="font-bold text-slate-800 mb-2 text-base">Rincian Pembayaran</h3>
                
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span>Harga Sewa ({{ $duration }} Bulan)</span>
                    <span class="font-semibold text-slate-800" id="rentPriceDisplay">Rp 0</span>
                </div>
                
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span>PPN (11%)</span>
                    <span class="font-semibold text-slate-800" id="ppnDisplay">Rp 0</span>
                </div>
                
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span>Asuransi (1%)</span>
                    <span class="font-semibold text-slate-800" id="insuranceDisplay">Rp 0</span>
                </div>

                <div id="discountRow" class="justify-between items-center text-sm text-[#4FA8C0] hidden animate-pulse">
                    <span class="font-bold">Potongan Promo</span>
                    <span class="font-bold" id="discountDisplay">-Rp 0</span>
                </div>

                <div class="h-[1px] bg-gray-100 my-2"></div>
                
                <div class="flex justify-between items-center">
                    <span class="font-bold text-slate-800 text-base">Grand Total</span>
                    <span class="font-extrabold text-[#4FA8C0] text-xl" id="grandTotalDisplay">Rp 0</span>
                </div>
            </div>

            <!-- Input Hidden -->
            <input type="hidden" name="discount_amount" id="inputDiscount" value="0">
            <input type="hidden" name="grand_total" id="inputGrandTotal" value="0">
            <input type="hidden" name="promo_code" id="inputPromoCode" value="">

            <!-- Tombol Bayar -->
            <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-5 z-50">
                <div class="max-w-[640px] mx-auto flex items-center justify-between gap-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-400 font-medium">Total Bayar</span>
                        <span class="font-bold text-[#4FA8C0] text-xl" id="bottomTotalDisplay">Rp 0</span>
                    </div>
                    <button type="submit" class="flex-1 bg-[#4FA8C0] text-white py-3.5 rounded-full font-bold text-base shadow-lg shadow-[#4FA8C0]/30 hover:shadow-[#4FA8C0]/50 transition-all">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </form>
    @endif
@endsection

@section('scripts')
@if(!($isError ?? true))
<script>
    // DATA DARI SERVER (SAFE MODE)
    // Perbaikan: Bungkus dengan kutip dan konversi ke Number agar VS Code tidak error syntax
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

        document.getElementById('rentPriceDisplay').innerText = formatRupiah(subTotal);
        document.getElementById('ppnDisplay').innerText = formatRupiah(ppn);
        document.getElementById('insuranceDisplay').innerText = formatRupiah(insurance);

        const discountRow = document.getElementById('discountRow');
        const discountDisplay = document.getElementById('discountDisplay');
        
        if (discountValue > 0) {
            discountRow.classList.remove('hidden');
            discountRow.classList.add('flex');
            discountDisplay.innerText = '-' + formatRupiah(discountValue);
        } else {
            discountRow.classList.add('hidden');
            discountRow.classList.remove('flex');
        }

        document.getElementById('grandTotalDisplay').innerText = formatRupiah(grandTotal);
        document.getElementById('bottomTotalDisplay').innerText = formatRupiah(grandTotal);

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

        messageEl.innerText = "Memeriksa kode...";
        messageEl.className = "text-xs mt-2 font-medium text-gray-500";
        messageEl.classList.remove('hidden');

        try {
            const response = await fetch('/api/promo-check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                promoType = result.data.type;
                currentDiscount = result.data.discount_amount;
                
                messageEl.innerText = "✅ " + result.message;
                messageEl.className = "text-xs mt-2 font-bold text-green-600";
                document.getElementById('inputPromoCode').value = code;
            } else {
                throw new Error(result.message || "Kode tidak valid.");
            }

        } catch (error) {
            console.error(error);
            promoType = null;
            currentDiscount = 0;
            document.getElementById('inputPromoCode').value = "";
            messageEl.innerText = "❌ " + error.message;
            messageEl.className = "text-xs mt-2 font-bold text-red-500";
        }

        calculateTotal();
    }

    calculateTotal();
</script>
@endif
@endsection