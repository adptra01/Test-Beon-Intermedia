<?php

namespace Tests\Repositories;

use App\Models\House;
use App\Repositories\HouseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HouseRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected HouseRepository $houseRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->houseRepo = app(HouseRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_house()
    {
        $house = House::factory()->make()->toArray();

        $createdHouse = $this->houseRepo->create($house);

        $createdHouse = $createdHouse->toArray();
        $this->assertArrayHasKey('id', $createdHouse);
        $this->assertNotNull($createdHouse['id'], 'Created House must have id specified');
        $this->assertNotNull(House::find($createdHouse['id']), 'House with given id must be in DB');
        $this->assertModelData($house, $createdHouse);
    }

    /**
     * @test read
     */
    public function test_read_house()
    {
        $house = House::factory()->create();

        $dbHouse = $this->houseRepo->find($house->id);

        $dbHouse = $dbHouse->toArray();
        $this->assertModelData($house->toArray(), $dbHouse);
    }

    /**
     * @test update
     */
    public function test_update_house()
    {
        $house = House::factory()->create();
        $fakeHouse = House::factory()->make()->toArray();

        $updatedHouse = $this->houseRepo->update($fakeHouse, $house->id);

        $this->assertModelData($fakeHouse, $updatedHouse->toArray());
        $dbHouse = $this->houseRepo->find($house->id);
        $this->assertModelData($fakeHouse, $dbHouse->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_house()
    {
        $house = House::factory()->create();

        $resp = $this->houseRepo->delete($house->id);

        $this->assertTrue($resp);
        $this->assertNull(House::find($house->id), 'House should not exist in DB');
    }
}
