<?php

namespace Tests\Feature\App;

use App\Models\Basket;
use App\Models\BasketStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/** This test class is for testing features like adding, removing products from cart and to cart */
class UserBasketTest extends TestCase
{
    use RefreshDatabase;
    /**
     * This function tests that a logged in user can add a product to the cart
     *
     * @test
     */
    public function a_logged_in_user_can_add_a_product_to_the_cart(): void
    {
        // arrange
        $user = User::factory()->create([
            "email" => "jedavy.n@gmail.com"
        ]);
        Sanctum::actingAs($user);
        Product::factory(38)->create();
        $addedStatus = BasketStatus::factory()->create([
            "title" => "added"
        ]);
        BasketStatus::factory()->create([
            "title" => "removed"
        ]);
        BasketStatus::factory()->create([
            "title" => "bought"
        ]);
        $productID = Product::inRandomOrder()->first()->id;
        $itemsCount = 3;


        // act
        $response = $this->postJson("/api/app/cart/add", [
            "productID" => $productID,
            "itemsCount" => $itemsCount
        ]);


        // assert
        $response->assertStatus(200);
        $response->assertExactJson(["message" => "Product successfully added to cart"]);
        $cartAddition = Basket::where([["userID", $user->id], ["productID", $productID], ["statusID", $addedStatus->id]])->first();
        $this->assertModelExists($cartAddition);
        $this->assertCount(1, Basket::where("userID", $user->id)->get());
        $this->assertSame($itemsCount, $cartAddition->itemsCount);
    }
}
