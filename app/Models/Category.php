<?php

namespace App\Models;

use App\Scopes\AreasScope;
use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, UuidPrimaryKey;

    // 必须加上这一句
    public $incrementing  = false;

    const STATUS_ALL = 'all';
    const STATUS_DELETED = 'deleted';
    const STATUS_USING = 'using';

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
}
