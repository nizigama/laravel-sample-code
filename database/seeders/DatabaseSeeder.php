<?php

namespace Database\Seeders;

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
        User::factory(10)->create();
        Product::factory(98)->create();
        BasketStatus::factory()->create([
            "title" => "added"
        ]);
        BasketStatus::factory()->create([
            "title" => "removed"
        ]);
        BasketStatus::factory()->create([
            "title" => "bought"
        ]);
        Basket::factory(38)->create();
    }
}
