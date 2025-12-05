<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory, SoftDeletes;

    // INI YANG KURANG: Daftar kolom yang boleh diisi oleh Admin
    protected $fillable = [
        'image',
        'code',
        'description',
        'type',
        'discount_amount',
        'valid_from',
        'valid_until',
        'usage_limit',
        'is_active',
    ];

    // Opsional: Casting tipe data agar lebih aman
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];
}