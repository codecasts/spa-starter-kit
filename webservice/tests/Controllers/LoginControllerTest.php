<?php

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use JWTAuth;

class AuthControllerTest extends ApiTestCase
{
    use DatabaseMigrations, Factory;

    /**
     * @test
     */
    public function is_checking_for_invalid_credentials()
    {
        $this->makeInvalidRequest();

        $this->assertResponseStatus(401);
        $this->seeJsonStructure([
            'messages' => [[]],
        ]);
    }

    /**
     * @test
     */
    public function is_checking_for_login_throttle()
    {
        for ($i = 0; $i < 6; $i++) {
            $this->makeInvalidRequest();
        }

        $this->assertResponseStatus(429);
        $this->seeJsonStructure([
            'messages' => [[]],
        ]);
    }

    /**
     * @test
     */
    public function can_get_an_authenticated_token()
    {
        $user = $this->createUser();

        $this->json('POST', '/api/auth/issue', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'token', 'user' => [
                'id', 'name', 'email',
            ],
        ]);
    }

    /**
     * @test
     */
    public function is_checking_for_revoke_token()
    {
        $user = $this->createUser();

        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ];

        $this->json('POST', '/api/auth/revoke',[], $headers);

        $this->assertResponseStatus(204);

        $this->json('POST', '/api/auth/revoke',[], $headers);

        $this->assertResponseStatus(401);
    }

    /**
     * @test
     */
    public function check_unauthorized_access()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer invalid'
        ];

        $this->json('POST', '/api/auth/revoke',[], $headers);

        $this->assertResponseStatus(401);
        $this->seeJsonEquals([
            'error' => ['Unauthenticated.']
        ]);
    }

    private function makeInvalidRequest()
    {
        $this->json('POST', '/api/auth/issue', [
            'email' => 'hello@example.com',
            'password' => 'dummypassword',
        ]);
    }

    private function createUser()
    {
        return $this->create(User::class, [
            'email' => 'hello@example.com'
        ]);
    }
}
