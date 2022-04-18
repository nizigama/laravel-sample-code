<?php

namespace Database\Seeders;

use App\Enum\BasketStatusID;
use App\Models\Basket;
use App\Models\BasketStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $products = [
            [
              "name"=>"Pioneer DJ Mixer",
              "price"=>699
            ],
            [
              "name"=>"Roland Wave Sampler",
              "price"=>485
            ],
            [
              "name"=>"Reloop Headphone",
              "price"=>159
            ],
            [
              "name"=>"Rokit Monitor",
              "price"=>189.9
            ],
            [
              "name"=>"Fisherprice Baby Mixer",
              "price"=>120
            ]
            ];
        foreach($products as $product){
            Product::factory()->create([
                "name" => $product["name"],
                "price" => $product["price"],
            ]);
        }
        BasketStatus::factory()->create([
            "title" => "added"
        ]);
        BasketStatus::factory()->create([
            "title" => "removed"
        ]);
        BasketStatus::factory()->create([
            "title" => "bought"
        ]);
        Basket::factory(19)->create([
            "statusID" => BasketStatusID::ADDED->value
        ]);
        Basket::factory(7)->create([
            "siblingID" => Basket::where("statusID", BasketStatusID::ADDED->value)
                ->whereNotIn("id", Basket::where("statusID", BasketStatusID::REMOVED->value)
                    ->get("siblingID")->toArray())
                ->inRandomOrder()->first()->id,
            "statusID" => BasketStatusID::REMOVED->value
        ]);
    }
}
