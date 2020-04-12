<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'title' => 'required',
            'type' => [
                'required',
                Rule::in(Category::$types)
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '名称必须填写',
            'type.required' => '必须选择一个类型',
            'type.in' => '类型选择错误',
        ];
    }
}
