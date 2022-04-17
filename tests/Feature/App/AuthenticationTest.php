<?php

declare(strict_types=1);

namespace Tests\Feature\App;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

/**
 * 
 * This test class serves in testing for all authentication related features' tests.
 * i.e: register, login & logout
 * 
 */
class AuthenticationTest extends TestCase
{

    use RefreshDatabase;

    /** 
     * 
     * This function tests that anyone can create an account and get a valid bearer token
     * used in accessing protected resources
     * 
     * @test
     * 
     */
    public function anyone_can_signup(): void
    {
        // arrange
        $name = "Nizigama jean davy";
        $email = "jedavy.n@gmail.com";
        $password = "12345678";


        // act
        $response = $this->postJson("/api/auth/register", [
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "password_confirmation" => $password,
        ]);


        // assert
        $response->assertStatus(200);
        $response->assertJsonStructure(["token"]);
        $user = User::where("email", $email)->first();
        $this->assertModelExists($user);
        $this->assertSame($name, $user->name);
        $this->assertSame($email, $user->email);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertModelExists(PersonalAccessToken::findToken($response["token"]));
    }

    /** 
     * 
     * This function tests that an existing user can login and get a valid bearer token
     * used in accessing protected resources
     * 
     * @test
     * 
     */
    public function existing_user_can_login(): void
    {
        // arrange
        /** @var User */
        $user = User::factory()->create([
            "email" => "jedavy.n@gmail.com"
        ]);
        $user->createToken("userAuthToken");
        $user->createToken("userAuthToken");


        // act
        $response = $this->postJson("/api/auth/login", [
            "email" => $user->email,
            "password" => "password"
        ]);


        // assert
        $response->assertStatus(200);
        $response->assertJsonStructure(["token"]);
        $this->assertModelExists(PersonalAccessToken::findToken($response["token"]));
        $this->assertSame(1, $user->tokens()->count());
    }

    // /**
    //  * This function tests that a logged in user can logout, and delete all their tokens
    //  * 
    //  * @test
    //  */
    // public function logged_in_user_can_logout_deleting_all_their_tokens(): void {
    //     // arrange


    //     // act


    //     // assert
    // }
}
