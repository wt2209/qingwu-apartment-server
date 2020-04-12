<?php

namespace App\Models;

use App\Scopes\AreasScope;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['company_name', 'manager', 'manager_phone', 'linkman', 'linkman_phone', 'entered_at', 'remark'];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];


    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function setEnteredAtAttribute($value)
    {
        $this->attributes['entered_at'] = empty($value) ? '1000-01-01' : $value;
    }

    public function getEnteredAtAttribute($value)
    {
        return $value === '1000-01-01' ? '' : $value;
    }

    public static function booted()
    {
        static::addGlobalScope(new AreasScope);
    }
}
