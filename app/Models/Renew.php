<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renew extends Model
{
    protected $fillable = ['record_id', 'old_rent_end', 'new_rent_end', 'renewed_at'];

    public function record()
    {
        return $this->belongsTo(Record::class);
    }
}
