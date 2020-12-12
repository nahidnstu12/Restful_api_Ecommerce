<?php

use App\Category;
use App\Product;
use App\User;
use App\Transaction;;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        $userQuantity = 20;
        $categoryQuantity = 10;
        $productQuantity = 100;
        $transactionQuantity = 100;

        factory(User::class,$userQuantity)->create();
        factory(Category::class,$categoryQuantity)->create();
        factory(Product::class,$productQuantity)->create()->each(function($product){
            $cat = Category::all()->random(mt_rand(1,5))->pluck('id');
            $product->categories()->attach($cat);
        });
        factory(Transaction::class,$transactionQuantity)->create();
    }
}
