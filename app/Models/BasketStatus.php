<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketStatus extends Model
{
    use HasFactory;
    protected $table = "BasketStatus";
    protected $dateFormat = "U";
    protected $fillable = ["title"];
}
