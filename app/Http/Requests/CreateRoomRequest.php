<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends FormRequest
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
            'category_id' => 'required|integer|min:1',
            'area_id' => 'required|integer|min:1',
            'title' => 'required',
            'building' => 'required',
            'unit' => 'required',
            'number' => 'integer',
            'charge_rule' => 'array',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => '必须选择一个类型',
            'category_id.integer' => '类型错误',
            'category_id.min' => '类型错误',
            'area_id.required' => '必须选择所属区域',
            'area_id.integer' => '类型错误',
            'area_id.min' => '类型错误',
            'title.required' => '必须填写房间号',
            'building.required' => '必须填写楼号',
            'unit.required' => '必须填写单元',
            'number.integer' => '请正确填写房间人数',
            'charge_rule' => '请按示例正确填写缴费规则',
        ];
    }
}
