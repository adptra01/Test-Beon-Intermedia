<?php

namespace Tests\Repositories;

use App\Models\HouseResident;
use App\Repositories\HouseResidentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HouseResidentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected HouseResidentRepository $houseResidentRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->houseResidentRepo = app(HouseResidentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_house_resident()
    {
        $houseResident = HouseResident::factory()->make()->toArray();

        $createdHouseResident = $this->houseResidentRepo->create($houseResident);

        $createdHouseResident = $createdHouseResident->toArray();
        $this->assertArrayHasKey('id', $createdHouseResident);
        $this->assertNotNull($createdHouseResident['id'], 'Created HouseResident must have id specified');
        $this->assertNotNull(HouseResident::find($createdHouseResident['id']), 'HouseResident with given id must be in DB');
        $this->assertModelData($houseResident, $createdHouseResident);
    }

    /**
     * @test read
     */
    public function test_read_house_resident()
    {
        $houseResident = HouseResident::factory()->create();

        $dbHouseResident = $this->houseResidentRepo->find($houseResident->id);

        $dbHouseResident = $dbHouseResident->toArray();
        $this->assertModelData($houseResident->toArray(), $dbHouseResident);
    }

    /**
     * @test update
     */
    public function test_update_house_resident()
    {
        $houseResident = HouseResident::factory()->create();
        $fakeHouseResident = HouseResident::factory()->make()->toArray();

        $updatedHouseResident = $this->houseResidentRepo->update($fakeHouseResident, $houseResident->id);

        $this->assertModelData($fakeHouseResident, $updatedHouseResident->toArray());
        $dbHouseResident = $this->houseResidentRepo->find($houseResident->id);
        $this->assertModelData($fakeHouseResident, $dbHouseResident->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_house_resident()
    {
        $houseResident = HouseResident::factory()->create();

        $resp = $this->houseResidentRepo->delete($houseResident->id);

        $this->assertTrue($resp);
        $this->assertNull(HouseResident::find($houseResident->id), 'HouseResident should not exist in DB');
    }
}
