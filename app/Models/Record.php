<?php

namespace App\Models;

use App\Scopes\AreasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Record extends Model
{
    use SoftDeletes;

    const STATUS_LIVING = 'living';
    const STATUS_QUITTED = 'quitted';
    const STATUS_MOVED = 'moved';

    protected $fillable = [
        'type', 'area_id', 'category_id', 'room_id', 'person_id', 'charge_rule_id', 'charged_to',
        'company_id', 'record_at', 'rent_start', 'rent_end', 'proof_files', 'functional_title',
        'electric_start_base', 'water_start_base', 'electric_end_base', 'water_end_base',
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

    public function chargeRule()
    {
        return $this->belongsTo(ChargeRule::class);
    }

    public function toRoom()
    {
        return $this->belongsTo(Room::class, 'to_room', 'id');
    }

    public function getRentStartAttribute($value)
    {
        return $value === '1000-01-01' ? '' : $value;
    }

    public function getRentEndAttribute($value)
    {
        return $value === '1000-01-01' ? '' : $value;
    }

    public function getDeletedAtAttribute($value)
    {
        return substr($value, 0, 10);
    }

    public function getProofFilesAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k]['url'] = url(Storage::url($v['path']));
            }
        }
        return $value;
    }

    public static function booted()
    {
        static::addGlobalScope(new AreasScope);
    }
}
