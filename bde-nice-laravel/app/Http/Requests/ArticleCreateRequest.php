<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session()->has('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name'          =>  'required|max:255',
            'price'         =>  'required',
            'description'   =>  'required|max:255',
            'picture_name'  =>  'max:255',
            'picture'       =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories'    =>  'required'
        ];
    }
}
