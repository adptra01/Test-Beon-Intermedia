<?php

namespace App\Repositories;

use App\Models\Resident;

class ResidentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'ktp_photo',
        'status',
        'phone_number',
        'is_married',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Resident::class;
    }
}
