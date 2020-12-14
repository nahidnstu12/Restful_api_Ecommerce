<?php

namespace App;
use App\Product;

class Seller extends User
{
    // multiple product returns
    public function products()
    {
    	return $this->hasMany(Product::class);
    }
}
