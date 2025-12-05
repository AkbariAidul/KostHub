<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\BoardingHouse;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';
    
    protected function getStats(): array
    {
        // 1. PENDAPATAN BERSIH (Hanya yang statusnya SUCCESS/PAID)
        // Saya tambahkan 'succes' juga untuk antisipasi typo di database kamu
        $revenue = Transaction::whereIn('payment_status', ['success', 'paid', 'succes'])
            ->sum('total_amount');

        // 2. TOTAL TRANSAKSI (Volume Order)
        $totalTrx = Transaction::count();
        
        // 3. KOST AKTIF
        $totalKost = BoardingHouse::count();

        return [
            Stat::make('Total Omset', 'Rp ' . number_format($revenue, 0, ',', '.'))
                ->description('Uang masuk terverifikasi')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success') // Hijau artinya cuan
                ->chart([7, 3, 10, 5, 8, 15]), 

            Stat::make('Total Transaksi', $totalTrx)
                ->description('Semua order masuk')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),

            Stat::make('Unit Kost', $totalKost)
                ->description('Total properti terdaftar')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('gray'),
        ];
    }
}