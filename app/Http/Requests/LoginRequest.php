<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class LoginRequest extends FormRequest
{
    public User $user;
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
            "email" => "required|email:rfc,dns",
            "password" => "required|string|min:8"
        ];
    }

    /**
     * Validates the provided credentials and throws 'invalid credentials error'
     */
    public function withValidator(Validator $validator): void
    {
        if (!$validator->fails()) {
            $this->user = User::where("email", $validator->validated()["email"])->first();
            
            $validator->after(function (Validator $validator) {

                if (is_null($this->user)) {
                    $validator->errors()->add('email', 'No record with that was found');
                    return;
                }

                if (!Hash::check($validator->validated()["password"], $this->user->password)) {
                    $validator->errors()->add('password', 'Wrong credentials');
                    return;
                }
            });
        }
    }
}
