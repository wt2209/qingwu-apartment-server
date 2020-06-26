<?php

namespace App\Models;

use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class CompanyRename extends Model
{
    use UuidPrimaryKey;

    // 必须加上这一句
    public $incrementing  = false;

    protected $fillable = ['company_id', 'old_company_name', 'new_company_name', 'renamed_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
