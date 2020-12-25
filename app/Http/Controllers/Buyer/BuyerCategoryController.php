<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // values  -> empty data removes when using unique()
        // collapse -> multiple collection returns single collection

        $category = $buyer->transactions()->with('product.categories')->get()->pluck('product.categories')
        ->collapse()
        ->unique('id')->values();
        

        return $this->showAll($category);
    }

   
}