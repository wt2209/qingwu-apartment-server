<?php

namespace App\Models;

use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Renew extends Model
{
    use UuidPrimaryKey;

    // 必须加上这一句
    public $incrementing  = false;

    protected $fillable = ['record_id', 'old_rent_end', 'new_rent_end', 'renewed_at'];

    public function record()
    {
        return $this->belongsTo(Record::class);
    }
}
