<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoleRequest extends FormRequest
{
    protected $id;
    public function __construct(Request $request)
    {
        $this->id = $request->route()->role;
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
            'name' => 'required|unique:roles,name'
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['name'] = 'required|unique:roles,name,' .$this->id;
        }

        return $rules;
    }
}
