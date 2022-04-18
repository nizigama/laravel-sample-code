<?php

namespace App\Http\Requests;

use App\Models\Basket;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class AddToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "productID" => "required|numeric|min:1",
            "itemsCount" => "numeric|min:1",
        ];
    }

    /**
     * Validates the provided credentials and throws 'invalid credentials error'
     */
    public function withValidator(Validator $validator): void
    {
        if (!$validator->fails()) {
            $product = Product::find($validator->validated()["productID"]);

            $validator->after(function (Validator $validator) use ($product) {

                if (is_null($product)) {
                    $validator->errors()->add('productID', 'No product found with ID');
                    return;
                }
            });

            $validator->after(function (Validator $validator) use ($product) {
                $alreadyInBasket = Basket::where([["userID", Auth::id()], ["productID", $product->id], ["statusID", 1]])->exists();

                if ($alreadyInBasket) {
                    $validator->errors()->add('productID', 'Product already in the cart');
                    return;
                }
            });
        }
    }
}
