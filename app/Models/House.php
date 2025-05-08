<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="House",
 *      required={"house_number","status"},
 *
 *      @OA\Property(
 *          property="house_number",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
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
 */ class House extends Model
{
    use HasFactory;

    public $table = 'houses';

    public $fillable = [
        'house_number',
        'status',
    ];

    protected $casts = [
        'house_number' => 'string',
        'status' => 'string',
    ];

    public static array $rules = [
        'house_number' => 'required|unique:houses,house_number',
        'status' => 'required|in:dihuni,tidak_dihuni',
    ];
}
