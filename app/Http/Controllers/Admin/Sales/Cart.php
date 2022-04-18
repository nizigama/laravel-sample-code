<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use Illuminate\Http\Request;

class Cart extends Controller
{
    public function getProductsRemovedFromCartBeforeCheckout(){
        $products = Basket::getItemsRemovedFromBasket();
        return response()->json($products);
    }
}
