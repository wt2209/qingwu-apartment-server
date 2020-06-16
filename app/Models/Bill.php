<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    const TYPE_PERSON = ChargeRule::TYPE_PERSON;
    const TYPE_COMPANY = ChargeRule::TYPE_COMPANY;
    const TYPE_OTHER = ChargeRule::TYPE_OTHER;

    const WAY_BEFORE = ChargeRule::WAY_BEFORE;
    const WAY_AFTER = ChargeRule::WAY_AFTER;

    protected $fillable = [
        'area_id', 'type', 'way', 'location', 'name', 'title',
        'turn_in', 'money', 'description', 'late_rate', 'late_date',
        'charged_at', 'is_refund', 'should_charge_at', 'auto_generate',
    ];

    protected $casts = [
        'is_refund' => 'boolean',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
