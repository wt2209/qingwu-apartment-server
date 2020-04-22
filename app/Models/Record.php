<?php

namespace App\Models;

use App\Scopes\AreasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes;

    const STATUS_LIVING = 'living';
    const STATUS_QUITTED = 'quitted';
    const STATUS_MOVED = 'moved';

    protected $fillable = [
        'type', 'area_id', 'category_id', 'room_id', 'person_id',
        'company_id', 'record_at', 'rent_start', 'rent_end', 'proof_files',
    ];

    protected $casts = [
        'proof_files' => 'array',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

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

    public function getRentStartAttribute($value)
    {
        return $value === '1000-01-01' ? '' : $value;
    }

    public function getRentEndAttribute($value)
    {
        return $value === '1000-01-01' ? '' : $value;
    }

    public static function booted()
    {
        static::addGlobalScope(new AreasScope);
    }
}
