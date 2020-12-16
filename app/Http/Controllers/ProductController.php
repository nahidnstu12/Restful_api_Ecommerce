<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductController extends ApiController
{
    public function index()
    {
        $products = Product::all();
        return \response()->json(['data'=>$products],200);
    }

    public function show($id){
        
    }
}
