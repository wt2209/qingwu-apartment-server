<?php

namespace App\Models;

use App\Scopes\AreasScope;
use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use UuidPrimaryKey;

    // 必须加上这一句
    public $incrementing  = false;

    protected $fillable = ['company_name', 'manager', 'manager_phone', 'linkman', 'linkman_phone', 'remark'];

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
