<?php

namespace App\Http\Controllers;
use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    public function index()
    {
        $buyer = Buyer::has('transactions')->get();
        return $this->showAll($buyer);
    }

    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer);
    }

}
