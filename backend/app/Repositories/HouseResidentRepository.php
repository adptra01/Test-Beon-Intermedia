<?php

namespace App\Repositories;

use App\Models\HouseResident;

class HouseResidentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'house_id',
        'resident_id',
        'start_date',
        'end_date',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return HouseResident::class;
    }
}
