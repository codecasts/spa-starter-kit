<?php

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends ApiTestCase
{
    use DatabaseMigrations, Factory;

    /**
     * @test
     */
    public function is_checking_for_invalid_credentials()
    {
        $this->json('POST', '/api/login', [
            'email' => 'hello@example.com',
            'password' => 'dummypassword',
        ]);

        $this->assertResponseStatus(401);
        $this->seeJsonStructure([
            'messages' => [[]],
        ]);
    }

    /**
     * @test
     */
    public function can_get_an_authenticated_token()
    {
        $email = 'hello@example.com';
        $password = 'dummypassword';

        $this->create(User::class, [
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->json('POST', '/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'token', 'user' => [
                'id', 'name', 'email',
            ],
        ]);
    }
}
