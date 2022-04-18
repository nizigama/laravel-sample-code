<?php

namespace App\Http\Requests;

use App\Enum\BasketStatusID;
use App\Models\Basket;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RemoveFromCartRequest extends FormRequest
{
    public ?Basket $basketAdditionRecord;
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
            //
        ];
    }

    /**
     * Validates that the provided productID references an existing product and it's not yet in the cart
     */
    public function withValidator(Validator $validator): void
    {

        $this->basketAdditionRecord = Basket::find(request()->route("recordID"));

        $validator->after(function (Validator $validator) {

            if (is_null($this->basketAdditionRecord)) {
                $validator->errors()->add('recordID', 'No record found with that ID');
                return;
            }

            if ($this->basketAdditionRecord->statusID !== BasketStatusID::ADDED->value) {
                $validator->errors()->add('recordID', 'No basket addition record found with that ID');
                return;
            }
        });
    }
}
