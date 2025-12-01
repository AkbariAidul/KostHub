<?php

namespace App\Interfaces;

Interface TransactionRepositoryInterfaces
{
    public function getTransactionDataFromSession();

    public function saveTransactionDataToSession($data);

    public function saveTransaction($data);
    
    public function getTransactionByCode($code);

    public function getTransactionByCodeEmailPhone($code, $email, $phone);
}