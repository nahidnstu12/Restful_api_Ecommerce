<?php

namespace App;

use App\Scopes\BuyerScope;
use App\Transaction;

class Buyer extends User
{
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }
    // user have many transactions
    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }
}
