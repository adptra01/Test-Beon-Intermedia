<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Payment",
 *      required={"house_id","resident_id","month","type","amount","status"},
 *
 *      @OA\Property(
 *          property="month",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="type",
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
 *          property="status",
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
 */ class Payment extends Model
{
    use HasFactory;

    public $table = 'payments';

    public $fillable = [
        'house_id',
        'resident_id',
        'month',
        'type',
        'amount',
        'status',
    ];

    protected $casts = [
        'month' => 'string',
        'type' => 'string',
        'amount' => 'integer',
        'status' => 'string',
    ];

    public static array $rules = [
        'house_id' => 'required|exists:houses,id',
        'resident_id' => 'required|exists:residents,id',
        'month' => 'required|date_format:Y-m',
        'type' => 'required|in:kebersihan,satpam',
        'amount' => 'required|integer|min:0',
        'status' => 'required|in:lunas,belum',
    ];
}
