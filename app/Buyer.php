<?php

namespace App;
use App\Transaction;

class Buyer extends User
{
    // user have many transactions
    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }
}
