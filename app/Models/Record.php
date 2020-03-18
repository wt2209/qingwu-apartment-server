<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    const STATUS_LIVING = 'living';
    const STATUS_QUITTED = 'quitted';
    const STATUS_MOVED = 'moved';

    protected $dates = [
        'record_at',
        'rent_start',
        'rent_end',
    ];

    protected $casts = [
        'record_at' => 'date:Y-m-d',
        'rent_start' => 'date:Y-m-d',
        'rent_end' => 'date:Y-m-d',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'type', 'category_id', 'room_id', 'person_id',
        'company_id', 'record_at', 'rent_start', 'rent_end'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function toRoom()
    {
        return $this->belongsTo(Room::class);
    }
}
