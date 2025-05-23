<?php

namespace Tests\APIs;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions, WithoutMiddleware;

    /**
     * @test
     */
    public function test_create_user()
    {
        $user = User::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/users', $user
        );

        $this->assertApiResponse($user);
    }

    /**
     * @test
     */
    public function test_read_user()
    {
        $user = User::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/users/'.$user->id
        );

        $this->assertApiResponse($user->toArray());
    }

    /**
     * @test
     */
    public function test_update_user()
    {
        $user = User::factory()->create();
        $editedUser = User::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/users/'.$user->id,
            $editedUser
        );

        $this->assertApiResponse($editedUser);
    }

    /**
     * @test
     */
    public function test_delete_user()
    {
        $user = User::factory()->create();

        $this->response = $this->json(
            'DELETE',
            '/api/users/'.$user->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/users/'.$user->id
        );

        $this->response->assertStatus(404);
    }
}
