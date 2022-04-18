<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\BasketStatusID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Basket extends Model
{
    use HasFactory;
    protected $table = "Basket";
    protected $dateFormat = "U";
    protected $fillable = ["userID", "productID", "statusID", "siblingID", "itemsCount"];

    public static function getItemsRemovedFromBasket(): array
    {

        return DB::select("
                            SELECT a.name, a.price
                            FROM Product AS a
                            INNER JOIN Basket AS b
                            ON a.id = b.productID
                            INNER JOIN BasketStatus AS c
                            ON b.statusID = c.id
                            WHERE c.id = ? AND b.siblingID IS NOT NULL
                            GROUP BY a.id              
        ", [BasketStatusID::REMOVED->value]);
    }
}
