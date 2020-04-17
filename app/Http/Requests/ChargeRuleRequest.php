<?php

namespace App\Http\Requests;

use App\Models\ChargeRule;
use App\Models\FeeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChargeRuleRequest extends FormRequest
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
        $id = $this->route('id', null);
        return [
            'title' => ['required', Rule::unique('charge_rules')->ignore($id)],
            'period' => 'required|integer',
            'type' => ['required', Rule::in(ChargeRule::$typeMapper)],
            'way' => ['required', Rule::in(ChargeRule::$wayMapper)],
            'rule.*.title' => ['required', Rule::in(FeeType::pluck('title')->toArray())],
            'rule.*.fee' => 'sometimes|required',
            'rule.*.turn_in' => 'sometimes|required|boolean',
            'rule.*.rate' => 'sometimes|required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '名称必须填写',
            'title.unique' => '此名称已存在',
            'period.required' => '交费间隔必须填写',
            'period.integer' => '交费间隔必须是一个数字',
            'type.required' => '必须选择所属类型',
            'type.in' => '所属类型错误',
            'way.required' => '必须选择交费方式',
            'way.in' => '交费方式错误',
            'rule.*.title.required' => '必须填写费用名称',
            'rule.*.title.' => '费用名称非法',
            'rule.*.fee.required' => '必须填写费用名称',
            'rule.*.rate.required' => '必须填写滞纳金率',
            'rule.*.rate.numeric' => '滞纳金率必须是一个数字',
            'rule.*.turn_in.required' => '必须选择是否上交',
            'rule.*.turn_in.boolean' => '“是否上交”格式错误',
        ];
    }
}
