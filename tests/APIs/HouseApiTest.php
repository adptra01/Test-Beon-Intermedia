<?php

namespace Tests\APIs;

use App\Models\House;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HouseApiTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions, WithoutMiddleware;

    /**
     * @test
     */
    public function test_create_house()
    {
        $house = House::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/houses', $house
        );

        $this->assertApiResponse($house);
    }

    /**
     * @test
     */
    public function test_read_house()
    {
        $house = House::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/houses/'.$house->id
        );

        $this->assertApiResponse($house->toArray());
    }

    /**
     * @test
     */
    public function test_update_house()
    {
        $house = House::factory()->create();
        $editedHouse = House::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/houses/'.$house->id,
            $editedHouse
        );

        $this->assertApiResponse($editedHouse);
    }

    /**
     * @test
     */
    public function test_delete_house()
    {
        $house = House::factory()->create();

        $this->response = $this->json(
            'DELETE',
            '/api/houses/'.$house->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/houses/'.$house->id
        );

        $this->response->assertStatus(404);
    }
}
