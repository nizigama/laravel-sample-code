<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;
    protected $table = "Basket";
    protected $dateFormat = "U";
    protected $fillable = ["userID", "productID", "statusID", "siblingID", "itemsCount"];
}
