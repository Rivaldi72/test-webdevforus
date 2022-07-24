<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'group_id'      => 'required',
            'name'          => 'required',
            'address'       => 'required',
            'phone'         => 'required',
            'email'         => 'required',
            'profile_pic'   => 'required',
        ];
    }
}
