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
     * This funciton tests that anyone can create an accoutnand get a valid bearer token
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
}
