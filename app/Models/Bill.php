<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Bill extends Model
{
    // 使用uuid
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

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
