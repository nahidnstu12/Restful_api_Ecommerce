<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Seller;
use App\Transaction;
use App\Category;

class Product extends Model
{
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    protected $fillable = ['name','description','quantity','status','image','seller_id'];

    public function isAvailable(){
        return $this->status == Product::AVAILABLE_PRODUCT;
    }
    // single seller returns
    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    // multiple transaction returns
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    // multipe categories
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

}
