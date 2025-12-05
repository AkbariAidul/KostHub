<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MonthlyRevenueChart extends ChartWidget
{
    // Judul yang tampil di atas grafik
    protected static ?string $heading = 'Grafik Pendapatan Bulanan';

    // Mengatur urutan tampilan widget (agar muncul di bawah kartu statistik)
    protected static ?int $sort = 2;

    // Mengatur lebar widget agar memenuhi layar (Full Width)
    protected int | string | array $columnSpan = 'full';

    // ... code sebelumnya
    protected function getData(): array
    {
        $data = Trend::query(
                // Filter hanya transaksi sukses agar grafik akurat
                Transaction::query()->whereIn('payment_status', ['success', 'paid', 'succes'])
            )
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('total_amount');

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Bersih (Rupiah)',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#4FA8C0', 
                    'borderColor' => '#4FA8C0',
                    'fill' => true,
                    'tension' => 0.4, // Garis melengkung
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        // Jenis grafik: 'line' (garis), bisa diganti 'bar' (batang)
        return 'line';
    }
}