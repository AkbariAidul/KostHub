<?php

namespace App\Repositories;

use App\Interfaces\PromoCodeRepositoryInterface;
use App\Models\PromoCode;

class PromoCodeRepository implements PromoCodeRepositoryInterface
{
    public function getActivePromos()
    {
        return PromoCode::where('is_active', true)
            ->whereDate('valid_until', '>=', now()) // Hanya yang belum kadaluarsa
            ->latest()
            ->get();
    }
}