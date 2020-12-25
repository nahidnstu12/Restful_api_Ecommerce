<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Product $product,User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        $this->validate($request,$rules);

        if($buyer->id == $product->seller_id){
            // return $this->errorResponse('The buyer must be different from the seller',409);
            return \response()->json(['error'=>'The buyer must be different from the seller','code'=>409],409);
        }
        if(!$buyer->isVerified()){
            
            // return $this->errorResponse('The buyer must be verified',409);
            return \response()->json(['error'=>'The buyer must be verified','code'=>409],409);
        }
        if(!$product->seller->isVerified()){
            // return $this->errorResponse('The seller must be verified',409);
            return \response()->json(['error'=>'The seller must be verified','code'=>409],409);
        }
        if(!$product->isAvailable()){
            // return $this->errorResponse('The Product is not available',409);
            return \response()->json(['error'=>'The Product is not available','code'=>409],409);
        }
        if($product->quantity < $request->quantity){
            // return $this->errorResponse('The Product does not have enough units for this transactions',409);
            return \response()->json(['error'=>'The Product does not have enough units for this transactions','code'=>409],409);
        }

        return DB::transaction(function() use ($request,$product,$buyer){
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id

            ]);

            return $this->showOne($transaction,201);
        });
    }
}
