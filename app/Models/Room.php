<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['category_id', 'room_name', 'building', 'unit', 'rent', 'number', 'remark', 'status'];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
