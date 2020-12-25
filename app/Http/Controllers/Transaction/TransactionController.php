<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionController extends ApiController
{
    public function index()
    {
        $transaction = Transaction::all();
        return $this->showAll($transaction);
    }

    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }

}
