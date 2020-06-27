<?php

namespace App\Models;

use App\Scopes\AreasScope;
use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use UuidPrimaryKey;

    // 必须加上这一句
    public $incrementing  = false;

    protected $fillable = [
        'name', 'area_id', 'gender', 'education', 'serial', 'identify',
        'phone', 'department', 'hired_at', 'contract_start',
        'contract_end', 'emergency_person', 'emergency_phone', 'origin', 'remark',
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function setContractEndAttribute($value)
    {
        $this->attributes['contract_end'] = $value === '无固定期' ? '3000-01-01' : $value;
    }

    public function getContractEndAttribute($value)
    {
        return $value === '3000-01-01' ? '无固定期' : $value;
    }
}
