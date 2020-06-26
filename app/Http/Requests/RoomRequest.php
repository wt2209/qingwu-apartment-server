<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
        $areaId = $this->input('area_id', 0);
        $id = $this->route('id', null);

        return [
            'category_id' => 'required',
            'area_id' => 'required',
            'title' => [
                'required',
                $id
                    ? Rule::unique('rooms')->where(function ($query) use ($areaId) {
                        return $query->where('area_id', $areaId);
                    })->ignore($id)
                    : Rule::unique('rooms')->where(function ($query) use ($areaId) {
                        return $query->where('area_id', $areaId);
                    }),
            ],
            'building' => 'required',
            'unit' => 'required',
            'number' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => '必须选择一个类型',
            'category_id.min' => '类型错误',
            'area_id.required' => '必须选择所属区域',
            'area_id.min' => '类型错误',
            'title.required' => '必须填写房间号',
            'title.unique' => '此房间已存在',
            'building.required' => '必须填写楼号',
            'unit.required' => '必须填写单元',
            'number.integer' => '请正确填写房间人数',
        ];
    }
}
