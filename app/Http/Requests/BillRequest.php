<?php

namespace App\Http\Requests;

use App\Models\FeeType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
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
            'type' => 'required|in:person,company,other',
            'area_id' => 'required|integer',
            'location' => 'required',
            'money' => 'required|numeric',
            'title' => ['required', Rule::in(FeeType::pluck('title')->toArray())],
            'late_rate' => 'numeric',
            'late_date' => 'date_format:Y-m-d',
            'late_base' => 'numeric',
            'should_charge_at' => 'date_format:Y-m-d',
            'charged_at' => 'sometimes|required|date_format:Y-m-d',
            'way' => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '类型必须填写',
            'type.in' => '类型填写错误',
            'area_id.required' => '区域必须填写',
            'area_id.integer' => '区域填写错误',
            'location.required' => '房间/位置必须填写',
            'money.required' => '金额必须填写',
            'money.numeric' => '金额填写错误',
            'title.required' => '费用类型必须填写',
            'title.in' => '费用类型填写错误',
            'late_rate.numeric' => '滞纳金费率错误',
            'late_date.date_format' => '滞纳金费开始日期错误',
            'late_rate.numeric' => '滞纳金基数错误',
            'should_charge_at.date_format' => '最晚缴费日期错误',
            'charged_at.required' => '缴费日期必须填写',
            'charged_at.date_format' => '缴费日期错误',
            'way.required' => '缴费方式必须填写',
        ];
    }
}
