<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Resident",
 *      required={"name","status","is_married"},
 *
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="ktp_photo",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
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
 *          property="phone_number",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="is_married",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
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
 */ class Resident extends Model
{
    use HasFactory;

    public $table = 'residents';

    public $fillable = [
        'name',
        'ktp_photo',
        'status',
        'phone_number',
        'is_married',
    ];

    protected $casts = [
        'name' => 'string',
        'ktp_photo' => 'string',
        'status' => 'string',
        'phone_number' => 'string',
        'is_married' => 'boolean',
    ];

    public static array $rules = [
        'name' => 'required|min:3',
        'ktp_photo' => 'nullable|url',
        'status' => 'required|in:tetap,kontrak',
        'phone_number' => 'nullable|digits_between:9,15',
        'is_married' => 'required|boolean',
    ];
}
