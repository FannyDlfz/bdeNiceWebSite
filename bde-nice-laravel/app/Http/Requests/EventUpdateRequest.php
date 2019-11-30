<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
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
            'name'          =>  'required|max:255',
            'recurrence'    =>  'required|max:255',
            'price'         =>  'required|max:11' ,
            'description'   =>  'required|max:255',
            'begin_at'      =>  'required|max:255',
            'end_at'        =>  'required|max:255'
        ];
    }
}
