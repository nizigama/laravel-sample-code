<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Products extends Controller
{
    public function index(){
        return response()->json(Product::all(["name", "price"]));
    }
}
