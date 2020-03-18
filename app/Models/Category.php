<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const TYPE_PERSON = 'person';
    const TYPE_COMPANY = 'company';
    const TYPE_FUNCTIONAL = 'functional';

    protected $casts = [
        'charge_rule' => 'array',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    protected $dates = [];

    protected $fillable = ['title', 'type', 'utility_type', 'charge_rule', 'remark', 'status'];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
