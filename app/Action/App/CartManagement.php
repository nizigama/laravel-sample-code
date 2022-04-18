<?php

declare(strict_types=1);

namespace App\Action\App;

use App\Models\Basket;
use App\Models\BasketStatus;
use Illuminate\Support\Facades\Log;

class CartManagement
{
    public static function addAProductToTheCart(int $userID, int $productID, int $itemsCount): bool
    {
        $basketAddition = Basket::create([
            "userID" => $userID,
            "productID" => $productID,
            "statusID" => BasketStatus::first()->id,
            "itemsCount" => $itemsCount
        ]);
        return is_null($basketAddition) ? false : true;
    }
}
