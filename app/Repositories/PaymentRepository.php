<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'house_id',
        'resident_id',
        'month',
        'type',
        'amount',
        'status',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Payment::class;
    }
}
