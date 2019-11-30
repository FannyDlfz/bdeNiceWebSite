<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventCreateRequest extends FormRequest
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
            'description'   =>  'required|max:255',
            'begin_at'      =>  'required|max:255',
            'end_at'        =>  'required|max:255',
            'categories'    =>  'required',
            'picture_name',
            'picture'       =>  'image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
