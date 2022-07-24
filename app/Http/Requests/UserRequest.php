<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'              => 'required',
                    'email'             => 'required|unique:users,email',
                    'password'          => 'required',
                    'role_id'           => 'required',
                ];
                break;
            case 'PUT':
                return [
                    'name'              => 'required',
                    'email'             => 'required|unique:users,email,' . $this->user->id,
                    'role_id'           => 'required',
                    'password'          => 'nullable'
                ];
                break;
        }
    }
}
