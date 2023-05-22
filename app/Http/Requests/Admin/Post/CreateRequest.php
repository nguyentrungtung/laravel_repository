<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => 'required|max:250|min:5',
            'summary' => 'required|max:250',
            'thumbnail' => 'required',
            'author' => 'required|max:250',
            'label' => 'required|max:250',
            'description' => 'required|min:5',
            'status' => 'required|max:59',
            'meta_robot' => 'required',
            'schema' => 'required|json',
            'info_admin' => 'required',
        ];
    }
}
