<?php

declare(strict_types=1);

namespace App\Http\Controllers\App;

use App\Action\App\CartManagement;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RemoveFromCartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cart extends Controller
{
    public function addToCart(AddToCartRequest $request)
    {
        $added = CartManagement::addAProductToTheCart(Auth::id(), $request->productID, intval($request->itemsCount ?? 1));

        if ($added) {
            return response()->json(["message" => "Product successfully added to cart"]);
        }

        return response()->json(["message" => "Failed to add product to cart"], 500);
    }

    public function removeFromCart(RemoveFromCartRequest $request, int $recordID)
    {
        $removed = CartManagement::removeAProductFromTheCart($request->basketAdditionRecord);

        if ($removed) {
            return response()->json(["message" => "Product successfully removed from the cart"]);
        }

        return response()->json(["message" => "Failed to remove product from the cart"], 500);
    }
}
