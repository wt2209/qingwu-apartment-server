<?php

namespace App\Models;

use App\Scopes\AreasScope;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['title', 'description'];

    public static function booted()
    {
        static::addGlobalScope(new AreasScope);
    }
}
