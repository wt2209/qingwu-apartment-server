<?php

namespace App\Models;

use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Bill extends Model
{
    use UuidPrimaryKey;

    // 必须加上这一句
    public $incrementing  = false;

    const TYPE_PERSON = ChargeRule::TYPE_PERSON;
    const TYPE_COMPANY = ChargeRule::TYPE_COMPANY;
    const TYPE_OTHER = ChargeRule::TYPE_OTHER;

    protected $fillable = [
        'id', 'area_id', 'type', 'location', 'name', 'title',
        'turn_in', 'money', 'description', 'late_rate', 'late_date', 'late_base',
        'charged_at', 'charge_way', 'is_refund', 'should_charge_at', 'auto_generate',
    ];

    protected $casts = [
        'is_refund' => 'boolean',
        'auto_generate' => 'boolean',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
