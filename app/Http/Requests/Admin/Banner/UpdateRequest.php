<?php

namespace App\Http\Requests\Admin\Banner;

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
        return [
            'title' => 'required',
            'subtitle' => 'required',
            'thumbnail' => 'required',
            'view' => 'required',
            'description' => 'required',
            'status' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keyword' => 'required',
            'seo_canonical' => 'required',
        ];
    }
}
