<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeType extends Model
{
    use SoftDeletes;

    const STATUS_ALL = 'all';
    const STATUS_DELETED = 'deleted';
    const STATUS_USING = 'using';

    protected $fillable = ['title', 'rate', 'turn_in', 'remark'];
}
