<?php

namespace App\Repositories;

use App\Models\Expense;

class ExpenseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'date',
        'description',
        'amount',
        'category',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Expense::class;
    }
}
