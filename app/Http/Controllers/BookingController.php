<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingShowRequest;
use App\Http\Requests\CustomerInformationStoreRequest;
use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterfaces;
use App\Models\PromoCode; // [BARU] Import Model PromoCode
use Illuminate\Http\Request;
use App\Services\TwilioService; 

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

        // [PERBAIKAN ERROR] Cek apakah data transaction ada dan memiliki room_id
        if (empty($transaction) || !isset($transaction['room_id'])) {
            return redirect()->route('home')->with('error', 'Sesi booking telah berakhir, silakan ulangi proses.');
        }

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
        
        // [PERBAIKAN] Validasi sesi di sini juga biar aman
        if (empty($transaction) || !isset($transaction['room_id'])) {
            return redirect()->route('home');
        }

        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.checkout', compact('transaction', 'boardingHouse', 'room'));
    }

public function payment(Request $request)
{
    // 1. Ambil data session
    $transactionData = $this->transactionRepository->getTransactionDataFromSession();
    
    // Masukkan payment_method
    if ($request->has('payment_method')) {
        $transactionData['payment_method'] = $request->payment_method;
    }

    // Validasi
    if (!$transactionData || !isset($transactionData['room_id']) || !isset($transactionData['payment_method'])) {
        return redirect()->back()->with('error', 'Mohon pilih metode pembayaran kembali.');
    }

    // 2. Simpan ke Database (Repository membuat code default, misal: TRX-001)
    $transaction = $this->transactionRepository->saveTransaction($transactionData);

    // ============================================================
    // [STEP KRUSIAL] UPDATE KODE TRANSAKSI AGAR UNIK
    // ============================================================
    // Kita timpa kode yang dibuat repository supaya Midtrans menganggap ini transaksi baru
    $newCode = 'TRX-' . mt_rand(10000, 99999) . '-' . time();
    $transaction->code = $newCode;
    $transaction->save(); // Simpan kode baru ini ke database
    // ============================================================

    // 3. Hitung Ulang Total
    $grandTotal = $transaction->total_amount; 

    // Logika Diskon
    $promoCode = null;
    $promoApplied = false;

    if (session()->has('promo_code')) {
        $promoCode = \App\Models\PromoCode::where('code', session('promo_code'))->first();
        
        if ($promoCode && $promoCode->quota > 0) {
            if($promoCode->type == 'percentage') {
                 $discountAmount = $grandTotal * ($promoCode->discount / 100);
            } else {
                 $discountAmount = $promoCode->discount; 
            }
            
            $grandTotal = $grandTotal - $discountAmount; 
            $promoApplied = true;
        }
    }
    
    // Safety check
    if ($grandTotal < 1) { $grandTotal = 1; }

    // 4. Update Harga Final ke Database
    // Kita update lagi supaya harga di DB sinkron dengan harga yang dikirim ke Midtrans
    $transaction->total_amount = $grandTotal;
    if ($promoApplied) {
        $transaction->promo_code_id = $promoCode->id;
        $promoCode->decrement('quota');
    }
    $transaction->save(); // Save final

    // ==========================================================
    // SETUP MIDTRANS
    // ==========================================================
    \Midtrans\Config::$serverKey = config('midtrans.serverKey');
    \Midtrans\Config::$isProduction = config('midtrans.isProduction');
    \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
    \Midtrans\Config::$is3ds = config('midtrans.is3ds');

    $params = [
        'transaction_details' => [
            'order_id' => $newCode, // GUNAKAN KODE BARU YANG KITA BUAT TADI
            'gross_amount' => (int) ceil($grandTotal), 
        ],
        'customer_details' => [
            'first_name' => $transaction->name,
            'email' => $transaction->email,
            'phone_number' => $transaction->phone_number ?? $transaction->phone,
        ],
    ];

    // Debugging (Opsional): Uncomment baris bawah ini kalau masih salah harga
    // dd($params, $transaction); 

    $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

    return redirect($paymentUrl);
}
    public function succes(Request $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCode($request->order_id);

        if (!$transaction) {
            return redirect()->route('home');
        }

        // Hapus session promo code setelah sukses
        session()->forget('promo_code');

        return view('pages.booking.succes', compact('transaction'));
    }

    public function check()
    {
        return view('pages.booking.check-booking');
    }

    public function show(BookingShowRequest $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCodeEmailPhone(
            $request->code, 
            $request->email, 
            $request->phone_number 
        );

        if (!$transaction) {
            return redirect()->back()->with('error', 'Data Transaksi Tidak Ditemukan');
        }

        return view('pages.booking.detail', compact('transaction'));
    }
}