<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    /**
     *  get buyer's all products
     *  transaction -> product_id,buyer_id
     *  product -> id
     *  users -> id
     */


    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()->with('product')
                    ->get()->pluck('product');

        return $this->showAll($products);
    }

    
}
