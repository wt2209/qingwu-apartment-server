<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeeTypeRequest extends FormRequest
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
            'title' => [
                'required',
                Rule::unique('fee_types')->ignore($id),
            ],
            'turn_in' => 'required|boolean',
            'rate' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '名称必须填写',
            'title.unique' => '此名称已存在',
            'turn_in.required' => '必须选择是否上交',
            'turn_in.boolean' => '非法的是否上交字段',
            'rate.numeric' => '每日滞纳金率必须是一个数字',
        ];
    }
}
