<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CouponRequest extends FormRequest
{
    protected $id;
    public function __construct(Request $request)
    {
        $this->id =  $request->route()->coupon;
    }

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
        $rules = [
            'name' => 'required|min:2|max:255|unique:coupons,name',
            'use_type' => ['required'],
            'maximum_use_limit' => [''],
            'discount_type' => ['required'],
            'discount_value' => ['required'],
            'minimum_amount' => [''],
            'start_date' => ['required'],
            'end_date' => ['required'],
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['name'] = 'required|min:2|max:255|unique:coupons,name,'.$this->id;
        }

        return $rules;
    }
}
