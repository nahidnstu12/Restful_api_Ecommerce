<?php

namespace App;
use App\Product;
use App\Buyer;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['quantity','buyer_id','product_id'];

    // single buyer returns
    public function buyer()
    {
    	return $this->belongsTo(Buyer::class);
    }
    // single product returns
    public function products()
    {
    	return $this->belongsTo(Product::class);
    }
}
