<?php

namespace App\Models;

use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeType extends Model
{
    use SoftDeletes, UuidPrimaryKey;

    // 必须加上这一句
    public $incrementing  = false;

    const STATUS_ALL = 'all';
    const STATUS_DELETED = 'deleted';
    const STATUS_USING = 'using';

    protected $fillable = ['title', 'rate', 'turn_in', 'remark'];
}
