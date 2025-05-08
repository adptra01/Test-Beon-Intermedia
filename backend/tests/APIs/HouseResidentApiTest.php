<?php

namespace Tests\APIs;

use App\Models\HouseResident;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HouseResidentApiTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions, WithoutMiddleware;

    /**
     * @test
     */
    public function test_create_house_resident()
    {
        $houseResident = HouseResident::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/house-residents', $houseResident
        );

        $this->assertApiResponse($houseResident);
    }

    /**
     * @test
     */
    public function test_read_house_resident()
    {
        $houseResident = HouseResident::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/house-residents/'.$houseResident->id
        );

        $this->assertApiResponse($houseResident->toArray());
    }

    /**
     * @test
     */
    public function test_update_house_resident()
    {
        $houseResident = HouseResident::factory()->create();
        $editedHouseResident = HouseResident::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/house-residents/'.$houseResident->id,
            $editedHouseResident
        );

        $this->assertApiResponse($editedHouseResident);
    }

    /**
     * @test
     */
    public function test_delete_house_resident()
    {
        $houseResident = HouseResident::factory()->create();

        $this->response = $this->json(
            'DELETE',
            '/api/house-residents/'.$houseResident->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/house-residents/'.$houseResident->id
        );

        $this->response->assertStatus(404);
    }
}
