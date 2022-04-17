<?php

namespace Tests\Feature\App;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListProductsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * This function tests that anyone can view the product on sale
     *
     * @test
     */
    public function anyone_can_view_products_being_sold(): void
    {
        // arrange
        $products = Product::factory(12)->create();


        // act
        $response = $this->get("/api/app/products");


        // assert
        $response->assertStatus(200);
        $response->assertExactJson($products->map(function ($px) {
            return [
                "name" => $px->name,
                "price" => $px->price,
            ];
        })->toArray());
    }
}
