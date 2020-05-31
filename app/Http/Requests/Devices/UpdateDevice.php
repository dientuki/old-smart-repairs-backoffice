<?php

namespace App\Http\Requests\Devices;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDevice extends FormRequest
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
            'tradename' => 'required|string|max:190',
            'technical_name' => 'required|string|max:190',
            'url' => 'url|nullable',
            'device_type_id' => 'required|numeric|exists:device_types,id',
            'brand_id' => 'required|numeric|exists:brands,id'
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
            'tradename' => __('devices.tradename'),
            'technical_name' => __('devices.technical_name'),
            'url' => __('devices.url'),
            'device_type_id' => trans_choice('device-types.device_type',1),
            'brand_id' => trans_choice('brands.brand', 1)
        ];
    }
}
