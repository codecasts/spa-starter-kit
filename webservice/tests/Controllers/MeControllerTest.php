<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeControllerTest extends ApiTestCase
{
    use DatabaseMigrations, Factory;

    /**
     * @test
     */
    public function can_get_the_user_authenticated_with_token()
    {
        // Create a new user in the database
        $user = $this->create(User::class, [
            'name' => 'Anakin Skywalker',
            'email' => 'anakin@deathstar.com',
        ]);

        // Generate user token
        $token = Auth::guard('api')->login($user);

        // Request informations about the current authenticated user
        $this->json('GET', '/api/me', [
            'token' => $token,
        ]);

        // Check if the request returned a 200 status code
        $this->assertResponseOk();

        // Check the JSON structure of the response
        $this->seeJsonStructure([
            'data' => [
                'name', 'email',
            ],
        ]);

        // Check if the user informations were returned correctly
        $this->seeJson([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
