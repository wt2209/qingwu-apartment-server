<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRenameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'new_company_name' => 'required|unique:companies,company_name',
            'renamed_at' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'new_company_name' => [
                'required' => '新公司名称必须填写',
                'unique' => '公司名称已存在',
            ],
            'renamed_at.required' => '改名时间必须填写',
        ];
    }
}
