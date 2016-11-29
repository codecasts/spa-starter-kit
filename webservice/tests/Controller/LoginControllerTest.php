<?php

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
            'password' => 'dummypassaord',
        ]);

        $this->assertResponseStatus(401);
        $this->seeJsonStructure([
            'messages' => [[]],
        ]);
    }
}
