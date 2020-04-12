<?php

namespace App\Models;

use App\Scopes\AreasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected $fillable = ['title', 'type', 'utility_type', 'charge_rule', 'remark', 'status'];

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
