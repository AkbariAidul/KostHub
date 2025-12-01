<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterfaces;

class TransactionRepository implements TransactionRepositoryInterfaces
{
    public function getTransactionDataFromSession()
    {
        return session()->get('transaction');
    }

    public function saveTransactionDataToSession($data)
    {
        $transaction = session()->get('transaction', []);

        foreach ($data as $key => $value)
        {
            $transaction[$key] = $value;
        }

        session()->put('transaction', $transaction);
    }
}