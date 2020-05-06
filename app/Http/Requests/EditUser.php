<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUser extends FormRequest
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
            'name' => 'required',
            'email' => 'required',         
            'password' => 'nullable',
            'password_confirm' => 'required_with:password|same:password'             
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('fields.name'),
            'email' => __('fields.email'),
            'password' => __('fields.password'),
            'password_confirm' => __('fields.password_confirm'),            
        ];
    }    
}