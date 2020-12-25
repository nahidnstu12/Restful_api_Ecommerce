<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    /**
     *  get product seller
     *  transaction -> product_id,buyer_id
     *  product -> id,seller_i
     *  users -> id
     */

    public function index(Buyer $buyer)
    {
        $seller = $buyer->transactions()->with('product.seller')->get()->pluck('product.seller')->unique('id')->values();
        return $this->showAll($seller);
    }

   
}
