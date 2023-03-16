<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */

    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5|max:50',
        ];
    }
    /**
     * show notification verify
     */
    public function messages(){
        return [
            'email.required'              => 'Email không được để trống',
            'email.max'                   => 'Email không được vượt quá 50 ký Tự',
            'password.required'           => 'Password không được để trống',
            'password.max'                => 'Password quá dài',
            'password.min'                => 'Password quá ngắn',
        ];
    }
}
