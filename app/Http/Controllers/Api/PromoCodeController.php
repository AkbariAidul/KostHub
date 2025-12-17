<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function check(Request $request)
    {
        $code = $request->input('code');

        $promo = PromoCode::where('code', $code)
            ->where('is_active', true)
            ->whereDate('valid_until', '>=', now())
            ->first();

        if (!$promo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode promo tidak valid atau kadaluarsa.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $promo,
            'message' => 'Kode promo berhasil digunakan!'
        ]);
    }
}