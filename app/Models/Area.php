<?php

namespace App\Models;

use App\Scopes\AreasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    const STATUS_ALL = 'all';
    const STATUS_DELETED = 'deleted';
    const STATUS_USING = 'using';

    protected $fillable = ['title', 'description'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public static function booted()
    {
        static::addGlobalScope(new AreasScope);
    }
}
