<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTransactions extends BaseWidget
{
    protected static ?int $sort = 3; // Posisi di bawah grafik
    protected int | string | array $columnSpan = 'full'; // Lebar penuh
    protected static ?string $heading = 'Transaksi Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Mengambil 5 transaksi terakhir, urut dari yang terbaru
                Transaction::query()->latest()
            )
            ->columns([
                // 1. KODE BOOKING (Bisa disearch & copyable)
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Booking')
                    ->searchable() // <--- INI KUNCINYA AGAR BISA DICARI
                    ->copyable()
                    ->weight('bold'),

                // 2. NAMA PENYEWA (Bisa disearch)
                Tables\Columns\TextColumn::make('name')
                    ->label('Penyewa')
                    ->searchable(), // <--- Tambahkan ini

                // 3. NAMA KOST (Relasi, Bisa disearch)
                Tables\Columns\TextColumn::make('boardingHouse.name')
                    ->label('Kost')
                    ->searchable(), // <--- Filament otomatis cari ke tabel relasi

                // 4. TOTAL BAYAR (Format Rupiah)
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->color('primary'),

                // 5. STATUS PEMBAYARAN (Badge Warna-warni)
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success', 'paid', 'succes' => 'success', // Hijau (Handle typo 'succes' db)
                        'pending' => 'warning', // Kuning
                        'failed', 'cancel' => 'danger', // Merah
                        default => 'gray',
                    }),
            ])
            ->paginated(false); // Matikan pagination agar tampilan dashboard tetap ringkas
    }
}