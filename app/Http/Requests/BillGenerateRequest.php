<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillGenerateRequest extends FormRequest
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
            'date' => 'required|date',
            'export' => 'required|boolean',
            'save' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日期必须填写',
            'date.date' => '日期格式错误',
            'export.required' => '必须选择是否导出',
            'export.boolean' => '必须选择是否导出',
            'save.required' => '必须选择是否保存',
            'save.boolean' => '必须选择是否保存',
        ];
    }
}
