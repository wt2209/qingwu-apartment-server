<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillChargeRequest extends FormRequest
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
            'ids' => 'required|array',
            'lates' => 'sometimes|required|array',
            'lates.*.area_id' => 'sometimes|required|integer',
            'lates.*.type' => 'sometimes|required',
            'lates.*.location' => 'sometimes|required',
            'lates.*.title' => 'sometimes|required',
            'lates.*.money' => 'sometimes|required|numeric|min:0',
            'charge_date' => 'required|date',
            'way' => 'required',
        ];
    }
}
