<?php

use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthControllerTest extends ApiTestCase
{
    use DatabaseMigrations, Factory;

    private $urlTokenIssue = '/api/auth/token/issue';
    private $urlTokenRevoke = '/api/auth/token/revoke';

    /**
     * @test
     */
    public function is_checking_for_invalid_credentials()
    {
        $this->json('POST', $this->urlTokenIssue, [
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

        $this->json('POST', $this->urlTokenIssue, [
            'email' => $email,
            'password' => $password,
        ]);

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'token',
            'token_ttl',
            'user' => [
		'data' => [
	                'id',
        	        'name',
                	'email',
		],
            ],
        ]);
    }

    /**
     * @test
     */
    public function is_checking_for_login_throttle()
    {
        for ($i = 0; $i < 6; $i++) {
            $this->makeRequestWithInvalidCredentials();
        }

        $this->assertResponseStatus(429);
        $this->seeJsonStructure([
            'messages' => [[]],
        ]);
    }

    /**
     * @test
     */
    public function is_checking_for_revoked_token()
    {
        $headers = $this->makeHeaders();

        $this->json('POST', $this->urlTokenRevoke, [], $headers);

        $this->assertResponseStatus(204);

        $this->json('POST', $this->urlTokenRevoke, [], $headers);

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

        $this->json('POST', $this->urlTokenRevoke, [], $headers);

        $this->assertResponseStatus(401);
        $this->seeJsonStructure([
            'messages' => [],
        ]);
    }

    /**
     * @test
     */
    public function check_access_without_token()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->json('POST', $this->urlTokenRevoke, [], $headers);

        $this->assertResponseStatus(400);
        $this->seeJsonStructure([
            'messages' => [],
        ]);
    }

    public function is_checking_for_refreshed_token()
    {
        $headers = $this->makeHeaders();

        $this->json('POST', '/api/auth/token/refresh', [], $headers);

        $this->assertResponseOk();
        $this->seeJsonStructure(['token', 'token_ttl']);
    }

    private function makeHeaders()
    {
        $user = $this->createUser();

        $token = JWTAuth::fromUser($user);

        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
    }

    private function makeRequestWithInvalidCredentials()
    {
        $this->json('POST', $this->urlTokenIssue, [
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
