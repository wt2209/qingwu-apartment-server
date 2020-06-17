<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRemoveRequest extends FormRequest
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
            'ids' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'ids.required' => '必须选择费用',
            'ids.array' => '必须选择费用',
        ];
    }
}
