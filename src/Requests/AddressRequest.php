<?php

namespace Wding\transcation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'address'  => 'required',
            'note' => 'required|max:20'
        ];
    }

    public function messages()
    {
        return [
            'address.required' => '地址必传',
            'note.required' => '备注不能为空',
            'note.max' => '备注长度不能超过20',
        ];
    }
}
