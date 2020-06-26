<?php

namespace App\Models;

use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use UuidPrimaryKey;

    // 必须加上这一句
    public $incrementing  = false;

    public $fillable = ['user_id', 'ip', 'method', 'path', 'inputs', 'url'];

    public $casts = [
        'inputs' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
