<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaRequest extends FormRequest
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
                Rule::unique('areas')->ignore($id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '区域名称必须填写！',
            'title.unique' => '区域名称已经存在！',
        ];
    }
}
