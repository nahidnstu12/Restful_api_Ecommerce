<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionController extends ApiController
{
    public function index()
    {
        $transaction = Transaction::all();
        return \response()->json(['data'=> $transaction],200);
    }

    public function show(Transaction $transaction)
    {
        //
    }

}
