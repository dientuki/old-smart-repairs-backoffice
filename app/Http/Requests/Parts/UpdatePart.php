<?php

namespace App\Http\Requests\Parts;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePart extends FormRequest
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
            'name' => 'required|string|max:190',
            'code' => 'nullable|string|max:190',
            'image' => 'nullable|string',
            'delete' => 'nullable|string',
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
            'name' => __('parts.name'),
            'code' => __('parts.code'),
            'image' => __('parts.image')
        ];
    }
}
