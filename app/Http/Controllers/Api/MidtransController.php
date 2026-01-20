<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\FonnteService;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Validasi signature Midtrans
        $serverKey = config('midtrans.serverKey');
        $hashedKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        // 2. Ambil data transaksi
        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;

        $transaction = Transaction::where('code', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 3. Update status pembayaran
        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type === 'credit_card') {
                    if ($request->fraud_status === 'challenge') {
                        $transaction->update(['payment_status' => 'pending']);
                    } else {
                        $transaction->update(['payment_status' => 'success']);
                    }
                }
                break;

            case 'settlement':
                $transaction->update(['payment_status' => 'success']);

                // 🔥 KIRIM WHATSAPP VIA FONNTE (HANYA SAAT SUCCESS)
                $wa = new FonnteService();

                $phone = $transaction->customer_phone; 
                // pastikan format: 628xxxxxxxxxx (tanpa +)

                $message =
                    "✅ *Pembayaran Berhasil!*\n\n" .
                    "Kode Transaksi: {$transaction->code}\n" .
                    "Total Bayar: Rp {$transaction->amount}\n\n" .
                    "Terima kasih telah melakukan pembayaran 🙏";

                $wa->sendMessage($phone, $message);
                break;

            case 'pending':
                $transaction->update(['payment_status' => 'pending']);
                break;

            case 'deny':
                $transaction->update(['payment_status' => 'failed']);
                break;

            case 'expire':
                $transaction->update(['payment_status' => 'expired']);
                break;

            case 'cancel':
                $transaction->update(['payment_status' => 'cancelled']);
                break;

            default:
                $transaction->update(['payment_status' => 'unknown']);
                break;
        }

        return response()->json(['message' => 'Callback received successfully']);
    }
}
