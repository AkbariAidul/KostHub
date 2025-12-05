<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingShowRequest;
use App\Http\Requests\CustomerInformationStoreRequest;
use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterfaces;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use App\Services\TwilioService; // Pastikan ini ter-import

class BookingController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    private TransactionRepositoryInterfaces $transactionRepository;

    public function __construct(
        BoardingHouseRepositoryInterface $boardingHouseRepository,
        TransactionRepositoryInterfaces $transactionRepository
    ) {
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function booking(Request $request, $slug)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());

        return redirect()->route('booking.information', $slug);
    }

    public function information($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.information', compact('transaction', 'boardingHouse', 'room'));
    }

    public function saveInformation(CustomerInformationStoreRequest $request, $slug)
    {
        $data = $request->validated();

        $this->transactionRepository->saveTransactionDataToSession($data);

        return redirect()->route('booking.checkout', $slug);
    }

    public function checkout($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.checkout', compact('transaction', 'boardingHouse', 'room'));
    }

    public function payment(Request $request)
    {
        // 1. Simpan data ke session & Database
        $this->transactionRepository->saveTransactionDataToSession($request->all());
        $transaction = $this->transactionRepository->saveTransaction($this->transactionRepository->getTransactionDataFromSession());

        // ==========================================================
        // INTEGRASI TWILIO (Kirim Notifikasi WA)
        // ==========================================================
        try {
            // Inisialisasi Service
            $twilio = new TwilioService();
            
            // Siapkan Pesan
            $message  = "Halo {$transaction->name}, Terima kasih telah booking di KostHub! 👋\n\n";
            $message .= "Kode Booking: *{$transaction->code}*\n"; // Bold di WA pakai bintang
            $message .= "Total: Rp " . number_format($transaction->total_amount, 0, ',', '.') . "\n";
            $message .= "Silahkan selesaikan pembayaran Anda.";

            // Cek nama kolom di DB (phone atau phone_number)
            // Menggunakan null coalescing operator untuk jaga-jaga
            $phoneTarget = $transaction->phone_number ?? $transaction->phone;

            if ($phoneTarget) {
                $twilio->sendMessage($phoneTarget, $message);
            }

        } catch (\Exception $e) {
            // Kita pakai try-catch agar jika Twilio error (misal kuota habis/internet down),
            // proses pembayaran Midtrans TETAP BERJALAN dan tidak error di user.
            \Illuminate\Support\Facades\Log::error("Gagal kirim WA Twilio: " . $e->getMessage());
        }
        // ==========================================================


        // 2. Setup Midtrans
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                // Pastikan menggunakan properti yang benar sesuai database
                'phone_number' => $transaction->phone_number ?? $transaction->phone,
            ],
        ];

        $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

        return redirect($paymentUrl);
    }

    public function succes(Request $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCode($request->order_id);

        if (!$transaction) {
            return redirect()->route('home');
        }

        return view('pages.booking.succes', compact('transaction'));
    }

    public function check()
    {
        return view('pages.booking.check-booking');
    }

    public function show(BookingShowRequest $request)
    {
        // Pastikan parameter di sini sesuai dengan nama kolom di database kamu
        // Saya melihat error sebelumnya ada isu di sini, jadi pastikan repository menerima parameter yang pas
        $transaction = $this->transactionRepository->getTransactionByCodeEmailPhone(
            $request->code, 
            $request->email, 
            $request->phone_number // Sesuaikan dengan input name di form HTML (phone atau phone_number)
        );

        if (!$transaction) {
            return redirect()->back()->with('error', 'Data Transaksi Tidak Ditemukan');
        }

        return view('pages.booking.detail', compact('transaction'));
    }
}