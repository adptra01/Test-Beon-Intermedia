<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Expense",
 *      required={"date","description","amount","category"},
 *
 *      @OA\Property(
 *          property="date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="amount",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="category",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Expense extends Model
{
    use HasFactory;

    public $table = 'expenses';

    public $fillable = [
        'date',
        'description',
        'amount',
        'category',
    ];

    protected $casts = [
        'date' => 'date',
        'description' => 'string',
        'amount' => 'integer',
        'category' => 'string',
    ];

    public static array $rules = [
        'date' => 'required|date',
        'description' => 'required|string',
        'amount' => 'required|integer|min:0',
        'category' => 'required|in:gaji satpam,token listrik,perbaikan,lainnya',
    ];
}
