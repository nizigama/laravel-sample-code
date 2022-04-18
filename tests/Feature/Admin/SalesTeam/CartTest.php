<?php

namespace Tests\Feature\Admin\SalesTeam;

use App\Enum\BasketStatusID;
use App\Models\Basket;
use App\Models\BasketStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{

    use RefreshDatabase;

    /**
     * This function tests that the sales' team can get the list of products that were added to the cart but removed before checkout
     *
     * @test
     */
    public function sales_team_can_list_products_removed_from_cart_before_checkout(): void
    {
        // arrange
        User::factory(12)->create();
        Product::factory(38)->create();
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


        // act
        $response = $this->get("/api/admin/sales-team/basket-removals");


        // assert
        $response->assertStatus(200);
        $itemsRemovedFromBasket = Basket::getItemsRemovedFromBasket();
        $response->assertExactJson($itemsRemovedFromBasket);
    }
}
