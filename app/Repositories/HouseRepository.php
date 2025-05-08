<?php

namespace App\Repositories;

use App\Models\House;

class HouseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'house_number',
        'status',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return House::class;
    }
}
