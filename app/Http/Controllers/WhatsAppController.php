<?php

namespace App\Http\Controllers;

use App\Services\FonnteService;

class WhatsAppController extends Controller
{
    protected FonnteService $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    public function test()
    {
        $result = $this->fonnte->sendMessage(
            '6282354625412',
            'Tes WhatsApp dari Laravel 11 🚀'
        );

        return response()->json($result);
    }
}
