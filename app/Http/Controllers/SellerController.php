<?php

namespace App\Http\Controllers;
use App\Seller;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
    public function index()
    {
        $seller = Seller::has('products')->get();
        return $this->showAll($seller);
    }

    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }

}
