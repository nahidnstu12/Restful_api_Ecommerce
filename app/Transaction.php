<?php

namespace App;
use App\Product;
use App\Buyer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
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
