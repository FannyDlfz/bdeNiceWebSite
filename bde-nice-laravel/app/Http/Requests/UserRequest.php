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
        return
        [
            'name'                  => 'required|max:255|alpha_num',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/',
            'password_confirmation' => 'same:password',
            'center'                => 'required'
        ];
    }
}
