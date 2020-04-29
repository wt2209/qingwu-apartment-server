<?php

namespace App\Http\Requests;

use App\Models\Record;
use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;

class LivingMoveRequest extends FormRequest
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
        $data = $this->all();
        $areaId = $data['area_id'] ?? '';
        $id = $this->route('id', null);
        return [
            'area_id' => 'required|integer|min:1',
            'title' => [
                'required',
                function ($attribute, $value, $fail) use ($areaId, $id) {
                    $room = Room::where('area_id', $areaId)->where('title', $value)->first();
                    if (!$room) {
                        $fail('房间不存在');
                    }
                    $type = Record::where('id', $id)->value('type');
                    if ($room && $room->category->type !== $type) {
                        $fail('两个房间的居住类型不一致');
                    }
                }
            ],
            'deleted_at' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '必须填写房间号',
            'area_id.required' => '必须选择区域',
            'area_id.integer' => '必须选择区域',
            'area_id.min' => '必须选择区域',
            'deleted_at.required' => '必须填写调房时间',
            'deleted_at.date' => '调房时间格式错误',
        ];
    }
}
