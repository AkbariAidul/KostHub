<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;

class TwilioController extends Controller
{
    public function send()
    {
        $twilio = new TwilioService();

        $twilio->sendMessage(
            '+6282354625412', 
            'Hello! Ini pesan dari Laravel dengan Twilio WhatsApp 🚀'
        );

        return 'Pesan WhatsApp berhasil dikirim!';
    }
}