<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    const STATUS_ALL = 'all';
    const STATUS_DELETED = 'deleted';
    const STATUS_USING = 'using';

    protected $fillable = ['category_id', 'area_id', 'room_name', 'building', 'unit', 'rent', 'number', 'remark', 'status'];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
