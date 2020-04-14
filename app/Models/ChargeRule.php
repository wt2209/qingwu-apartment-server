<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeRule extends Model
{
    protected $fillable = ['title', 'rule', 'period'];

    protected $casts = [
        'rule' => 'array',
    ];
}
