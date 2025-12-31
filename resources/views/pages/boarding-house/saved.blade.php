@extends('layouts.app')

@section('content')
    <div class="px-6 pt-10 pb-6 bg-white border-b border-slate-50 sticky top-0 z-30">
        <h1 class="font-extrabold text-2xl text-slate-800">Disimpan</h1>
        <p class="text-slate-400 text-sm mt-1">Daftar kos favoritmu.</p>
    </div>

    <div class="px-6 mt-6 pb-32 min-h-[60vh]">
        
        <div id="loading" class="hidden flex justify-center py-10">
            <div class="w-8 h-8 border-4 border-slate-200 border-t-[#4FA8C0] rounded-full animate-spin"></div>
        </div>

        <div id="emptyState" class="hidden flex flex-col items-center justify-center pt-20 opacity-60">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
            </div>
            <p class="text-slate-500 font-bold">Belum ada kos disimpan.</p>
            <a href="{{ route('find-kos') }}" class="mt-2 text-[#4FA8C0] font-bold text-sm hover:underline">Cari Kos Dulu</a>
        </div>

        <div id="savedList" class="flex flex-col gap-4"></div>
    </div>

    @include('includes.navigation')
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const savedList = document.getElementById('savedList');
        const emptyState = document.getElementById('emptyState');
        const loading = document.getElementById('loading');

        // 1. Ambil data slug dari Local Storage
        const savedSlugs = JSON.parse(localStorage.getItem('saved_kos')) || [];

        // 2. Jika kosong, tampilkan empty state
        if (savedSlugs.length === 0) {
            emptyState.classList.remove('hidden');
            return;
        }

        // 3. Jika ada, panggil API
        loading.classList.remove('hidden');

        fetch(`{{ route('api.kos.saved') }}?slugs=${savedSlugs.join(',')}`)
            .then(res => res.json())
            .then(data => {
                if(data.html) {
                    savedList.innerHTML = data.html;
                    // PENTING: Warnai tombol hati jadi merah setelah data dimuat
                    initSaveButtons(); 
                } else {
                    emptyState.classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                emptyState.classList.remove('hidden');
            })
            .finally(() => {
                loading.classList.add('hidden');a
            });
    });

    // Helper untuk mewarnai tombol hati di halaman ini
    function initSaveButtons() {
        const saved = JSON.parse(localStorage.getItem('saved_kos')) || [];
        document.querySelectorAll('.save-btn').forEach(btn => {
            if (saved.includes(btn.dataset.slug)) {
                const icon = btn.querySelector('.heart-icon');
                icon.setAttribute('fill', 'currentColor');
                icon.classList.add('text-red-500');
                btn.classList.add('text-red-500', 'bg-red-50', 'border-red-200');
            }
        });
    }
</script>
@endsection