<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    public $fillable = ['user_id', 'ip', 'method', 'path', 'inputs', 'url'];

    public $casts = [
        'inputs' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
