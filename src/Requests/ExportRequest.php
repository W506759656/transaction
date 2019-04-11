<?php

namespace Wding\Transaction\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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
            'number' => ['required', 'numeric'],
            'address_id' => ['required'],
            'coin_id' => ['required'],
            'pay_password' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'number.required' => '请输入提现金额',
            'number.number' => '提现金额只能为数字',
            'address_id.required' => '请选择提现地址',
            'coin_id.required' => '请选择提现币种',
            'pay_password.required' => '请填写交易密码'

        ];
    }
}
