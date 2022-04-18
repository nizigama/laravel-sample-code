<?php

declare(strict_types=1);

namespace App\Action\App;

use App\Enum\BasketStatusID;
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
            "statusID" => BasketStatusID::ADDED->value,
            "itemsCount" => $itemsCount
        ]);
        return is_null($basketAddition) ? false : true;
    }
    public static function removeAProductFromTheCart(Basket $addToCartRecord): bool
    {

        $basketRemoval = Basket::create([
            "userID" => $addToCartRecord->userID,
            "productID" => $addToCartRecord->productID,
            "statusID" => BasketStatusID::REMOVED->value,
            "siblingID" => $addToCartRecord->id,
        ]);

        return is_null($basketRemoval) ? false : true;
    }
}
