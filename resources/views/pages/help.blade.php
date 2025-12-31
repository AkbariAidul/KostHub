@extends('layouts.app')

@section('content')
    <div class="px-6 pt-10 pb-6 bg-white border-b border-slate-50 sticky top-0 z-30">
        <h1 class="font-extrabold text-2xl text-slate-800">Pusat Bantuan</h1>
        <p class="text-slate-400 text-sm mt-1">Kami siap membantu masalahmu.</p>
    </div>

    <div class="px-6 py-6 flex flex-col gap-6 pb-32">
        
        <div class="bg-primary/5 rounded-[24px] p-6 text-center border border-primary/20">
            <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" /></svg>
            </div>
            <h2 class="font-bold text-lg text-slate-800 mb-2">Butuh Bantuan Mendesak?</h2>
            <p class="text-slate-500 text-sm mb-6">Tim support kami online 24/7 untuk membantu bookingmu.</p>
            <a href="https://wa.me/6281234567890" target="_blank" class="block w-full py-3.5 bg-[#25D366] text-white rounded-full font-bold text-sm shadow-lg hover:shadow-xl transition-all">
                Chat WhatsApp Admin
            </a>
        </div>

        <div>
            <h3 class="font-bold text-lg text-slate-800 mb-4">Sering Ditanyakan</h3>
            <div class="flex flex-col gap-3">
                <details class="group bg-white rounded-2xl border border-slate-100 open:border-primary/50 open:ring-1 open:ring-primary/20 transition-all">
                    <summary class="flex items-center justify-between p-4 cursor-pointer font-bold text-slate-700 marker:content-none">
                        <span>Bagaimana cara booking?</span>
                        <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </summary>
                    <div class="px-4 pb-4 text-sm text-slate-500 leading-relaxed">
                        Pilih kos yang kamu suka, klik tombol "Pilih Kamar", isi data diri, dan lakukan pembayaran sesuai metode yang tersedia.
                    </div>
                </details>

                <details class="group bg-white rounded-2xl border border-slate-100 open:border-primary/50 open:ring-1 open:ring-primary/20 transition-all">
                    <summary class="flex items-center justify-between p-4 cursor-pointer font-bold text-slate-700 marker:content-none">
                        <span>Apakah bisa refund?</span>
                        <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </summary>
                    <div class="px-4 pb-4 text-sm text-slate-500 leading-relaxed">
                        Kebijakan refund tergantung pada masing-masing pemilik kos. Silakan hubungi admin sebelum melakukan pembatalan.
                    </div>
                </details>

                <details class="group bg-white rounded-2xl border border-slate-100 open:border-primary/50 open:ring-1 open:ring-primary/20 transition-all">
                    <summary class="flex items-center justify-between p-4 cursor-pointer font-bold text-slate-700 marker:content-none">
                        <span>Metode pembayaran apa saja?</span>
                        <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </summary>
                    <div class="px-4 pb-4 text-sm text-slate-500 leading-relaxed">
                        Kami menerima transfer Bank (Virtual Account), E-Wallet (GoPay, OVO, ShopeePay), dan Kartu Kredit.
                    </div>
                </details>
            </div>
        </div>
    </div>

    @include('includes.navigation')
@endsection