<?php

namespace App\Models;

use App\Scopes\AreasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 *
 * @package Petstore30
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OA\Schema(
 *     description="Category model",
 *     title="Category",
 *     required={"name", "photoUrls"},
 *     @OA\Xml(
 *         name="Category"
 *     )
 * )
 * 
 * @OA\Property(
 *     property="title",
 *     format="string",
 *     description="类型的名称",
 *     title="名称",
 * )
 * 
 * @OA\Property(
 *     property="type",
 *     format="string",
 *     description="居住类型",
 *     title="居住类型",
 * )
 *
 *
 * @OA\RequestBody(
 *     request="Category",
 *     description="Pet object that needs to be added to the store",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Category"),
 *     @OA\MediaType(
 *         mediaType="application/xml",
 *         @OA\Schema(ref="#/components/schemas/Category")
 *     )
 * )
 */
class Category extends Model
{
    use SoftDeletes;

    const TYPE_PERSON = 'person';
    const TYPE_COMPANY = 'company';
    const TYPE_FUNCTIONAL = 'functional';

    public static $types = [
        self::TYPE_PERSON,
        self::TYPE_COMPANY,
        self::TYPE_FUNCTIONAL,
    ];

    protected $casts = [
        'charge_rule' => 'array',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
        'deleted_at' => 'date:Y-m-d',
    ];

    protected $fillable = ['title', 'type', 'utility_type', 'remark', 'status'];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public static function booted()
    {
        static::addGlobalScope(new AreasScope);
    }
}
