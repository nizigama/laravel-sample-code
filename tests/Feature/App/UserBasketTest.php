<?php

namespace Tests\Feature\App;

use App\Enum\BasketStatusID;
use App\Models\Basket;
use App\Models\BasketStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/** This test class is for testing features like adding, removing products from cart and to cart */
class UserBasketTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp(): void{
        parent::setUp();

        $user = User::factory()->create([
            "email" => "jedavy.n@gmail.com"
        ]);
        Sanctum::actingAs($user);
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
    }
    /**
     * This function tests that a logged in user can add a product to the cart
     *
     * @test
     */
    public function a_logged_in_user_can_add_a_product_to_the_cart(): void
    {
        // arrange
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
        $cartAddition = Basket::where([["userID", Auth::id()], ["productID", $productID], ["statusID", BasketStatusID::ADDED->value]])->first();
        $this->assertModelExists($cartAddition);
        $this->assertCount(1, Basket::where("userID", Auth::id())->get());
        $this->assertSame($itemsCount, $cartAddition->itemsCount);
    }

    /**
     * This function tests that a logged in user can remove a product from the cart
     *
     * @test
     */
    public function a_logged_in_user_can_remove_a_product_from_the_cart(): void
    {
        // arrange
        $productID = Product::inRandomOrder()->first()->id;
        $itemsCount = 3;

        $record = Basket::factory()->create([
            "userID" => Auth::id(),
            "productID" => $productID,
            "statusID" => BasketStatusID::ADDED->value,
            "itemsCount" => $itemsCount
        ]);



        // act
        $response = $this->postJson("/api/app/cart/remove/$record->id");


        // assert
        $response->assertStatus(200);
        $response->assertExactJson(["message" => "Product successfully removed from the cart"]);
        $cartAddition = Basket::where([["userID", Auth::id()], ["productID", $productID], ["statusID", BasketStatusID::ADDED->value]])->first();
        $cartRemoval = Basket::where([["userID", Auth::id()], ["productID", $productID], ["statusID", BasketStatusID::REMOVED->value]])->first();
        $this->assertModelExists($cartAddition);
        $this->assertModelExists($cartRemoval);
        $this->assertCount(2, Basket::where("userID", Auth::id())->get());
    }
}
