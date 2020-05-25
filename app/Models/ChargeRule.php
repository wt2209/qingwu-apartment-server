<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChargeRule extends Model
{
    use SoftDeletes;

    const STATUS_ALL = 'all';
    const STATUS_DELETED = 'deleted';
    const STATUS_USING = 'using';

    const TYPE_PERSON = Category::TYPE_PERSON;
    const TYPE_COMPANY = Category::TYPE_COMPANY;
    const TYPE_OTHER = 'other'; // 其他收费，如超市费用等

    const WAY_BEFORE = 'before'; // 预交费
    const WAY_AFTER = 'after'; // 后付费

    public static $typeMapper = [
        self::STATUS_ALL,
        self::STATUS_DELETED,
        self::STATUS_USING,
    ];

    public static $wayMapper = [
        self::WAY_BEFORE,
        self::WAY_AFTER,
    ];

    protected $fillable = ['title', 'type', 'rule', 'period', 'way', 'period', 'remark'];

    protected $casts = [
        'rule' => 'array',
    ];

    public function setRuleAttribute($value)
    {
        foreach ($value as $k => $v) {
            if (is_string($v['fee'])) {
                $str = str_replace(['，', ' '], ',', $v['fee']);
                $arr = explode(',', $str);
                $filter = array_filter($arr, function ($value) {
                    return $value !== '';
                });
                $float = array_map(function ($value) {
                    return floatval($value);
                }, $filter);
                $value[$k]['fee'] = $float;
            }
        }
        $this->attributes['rule'] = json_encode($value);
    }
}
