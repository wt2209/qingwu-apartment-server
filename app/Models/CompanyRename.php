<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRename extends Model
{
    protected $fillable = ['company_id', 'old_company_name', 'new_company_name', 'renamed_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
