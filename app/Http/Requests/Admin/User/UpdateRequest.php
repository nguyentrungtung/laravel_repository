<?php

namespace App\Http\Requests\Admin\User;

use http\Message;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
//        $id = $this->route('user');

        return [
            'name'                   => 'max:50|min:4',
            'password'               => 'max:20',
            'password_confirmation'  => 'required_with:password|same:password',
        ];

    }

    public function messages()
    {
        return parent::messages(); // TODO: Change the autogenerated stub
    }
}