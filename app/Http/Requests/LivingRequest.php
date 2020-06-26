<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LivingRequest extends FormRequest
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
            'area_id' => 'required',
            'type' => ['required', Rule::in(Category::$types)],
            'category_id' => 'required',
            'room_id' => 'required',
            'person' => 'sometimes|required|array',
            'person.name' => 'required_with:person',
            'company' => 'sometimes|required|array',
            'company.company_name' => 'required_with:company',
            'functional_title' => 'sometimes|required',
            'record_at' => 'required|date',
            'rent_start' => 'date',
            'rent_end' => 'date',
            'proof_files' => 'sometimes|array',
            'proof_files.*.name' => 'required_with:proof_files',
            'proof_files.*.path' => 'required_with:proof_files',
            'proof_files.*.size' => 'required_with:proof_files',
            'proof_files.*.uid' => 'required_with:proof_files',
        ];
    }

    public function messages()
    {
        return [
            'area_id.required' => '缺少区域信息',
            'type.required' => '缺少type信息',
            'type.rule' => 'type错误',
            'category_id.required' => '缺少类型信息',
            'room_id' => '缺少房间信息',
            'person.required' => '缺少人员基本信息',
            'person.array' => '人员基本信息类型错误',
            'person.name.required_with' => '必须填写人员姓名',
            'company.required' => '缺少公司基本信息',
            'company.array' => '公司基本信息类型错误',
            'company.company_name.required_with' => '必须填写公司名称',
            'functional_title.required' => '必须填写功能用房名称',
            'record_at.required' => '入住日期必须填写',
            'record_at.date' => '入住日期必须是一个日期格式',
            'rent_start.date' => '租期开始日必须是一个日期格式',
            'rent_end.date' => '租期结束日必须是一个日期格式',
            'proof_files.array' => '入住凭证格式错误',
            'proof_files.*.name.required_with' => '文件name不能为空',
            'proof_files.*.size.required_with' => '文件size不能为空',
            'proof_files.*.path.required_with' => '文件path不能为空',
            'proof_files.*.uid.required_with' => '文件uid不能为空',
        ];
    }
}
