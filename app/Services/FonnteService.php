<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected string $token;
    protected string $baseUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token');

        if (!$this->token) {
            throw new \Exception('FONNTE_TOKEN tidak ditemukan di env');
        }
    }

    public function sendMessage(string $phone, string $message): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token, // ⚠️ INI PENTING
            ])->post($this->baseUrl, [
                'target'  => $phone,
                'message' => $message,
            ]);

            return [
                'success' => $response->successful(),
                'data'    => $response->json(),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
