<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'name' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'monthly_price' => 'required',
            'yearly_price' => 'required',
            'device_limit' => 'required',
            'download_limit_type' => 'required',
            'download_limit' => 'exclude_unless:download_limit_type,2|required',
            'logo' => 'mimes:jpg,jpeg,png|file|max:1024'
        ];
    }
}
