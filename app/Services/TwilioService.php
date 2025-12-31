<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        // Mengambil kredensial dari file .env
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        
        // Nomor pengirim dari Twilio (Sandbox)
        $this->from = 'whatsapp:' . env('TWILIO_WHATSAPP_FROM');
        
        $this->client = new Client($sid, $token);
    }

    /**
     * Kirim pesan teks biasa (Paling mudah untuk tes awal)
     */
    public function sendMessage($to, $message)
    {
        $to = $this->formatNumber($to);

        try {
            return $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);
        } catch (\Exception $e) {
            // Log error jika gagal (opsional)
            // \Log::error("Twilio Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper untuk format nomor HP (08xx -> whatsapp:+628xx)
     */
    private function formatNumber($number)
    {
        // Hapus spasi atau karakter non-angka
        $number = preg_replace('/[^0-9]/', '', $number);

        // Jika diawali 0, ganti dengan 62
        if (substr($number, 0, 1) == '0') {
            $number = '62' . substr($number, 1);
        }
        
        // Jika diawali 62, biarkan
        
        return 'whatsapp:+' . $number;
    }
}