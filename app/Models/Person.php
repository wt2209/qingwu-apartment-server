<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'name', 'gender', 'education', 'serial', 'identify',
        'phone', 'department', 'hired_at', 'entered_at', 'contract_start',
        'contract_end', 'emergency_person', 'emergency_phone', 'origin'
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function setHiredAtAttribute($value)
    {
        $this->attributes['hired_at'] = empty($value) ? '1000-01-01' : $value;
    }

    public function getHiredAtAttribute($value)
    {
        return $value === '1000-01-01' ? '' : $value;
    }

    public function setEnteredAtAttribute($value)
    {
        $this->attributes['entered_at'] = empty($value) ? '1000-01-01' : $value;
    }

    public function getEnteredAtAttribute($value)
    {
        return $value === '1000-01-01' ? '' : $value;
    }

    public function setContractStarttribute($value)
    {
        $this->attributes['contract_start'] = empty($value) ? '1000-01-01' : $value;
    }

    public function getContractStartAttribute($value)
    {
        return $value === '1000-01-01' ? '' : $value;
    }

    public function setContractEndAttribute($value)
    {
        if (empty($value)) {
            $result = '1000-01-01';
        } else if ($value === '无固定期') {
            $result = '3000-01-01';
        } else {
            $result = $value;
        }

        $this->attributes['contract_end'] = $result;
    }

    public function getContractEndAttribute($value)
    {
        switch ($value) {
            case '3000-01-01':
                return '无固定期';
            case '1000-01-01':
                return '';
            default:
                return $value;
        }
    }
}
