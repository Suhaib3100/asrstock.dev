<?php

namespace App\Http\Requests\Admin;

use App\Models\ProductType;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $max = (empty(getOption('product_price_max_limit')) ? 1:getOption('product_price_max_limit'));
        $min = (empty(getOption('product_price_min_limit')) ? 1:getOption('product_price_min_limit'));
        $rules = [
            'title' => 'bail|required|min:2',
            'description' => 'bail|nullable',
            'product_type_id' => 'required',
            'product_category_id' => 'required',
            'file_types' => 'required',
            'accessibility' => 'required',
            "tags.0" => ["bail","required"],
            "tags" => ["bail","required","array","min:1"],
            'thumbnail_image' => 'bail|nullable|image|mimes:jpg,jpeg,png',
            'use_this_photo' => 'exclude_unless:accessibility,2|required',
            'main_file' => 'bail|exclude_unless:accessibility,2|required|exclude_if:file_types,Other|mimes:'.request()->get('file_types'),
            'tax_id' => 'bail|nullable',
            'status' => 'bail|required',
            'attribution_required' => 'bail|nullable',
        ];


        if(request()->get('accessibility') == 1){
            $variation_ids = request()->get('variation_id');
            foreach(request()->get('variations') as $index => $variation){
                $rules['variations.'.$index] = 'bail|' . (!isset($variation_ids[$index]) ? 'required' : 'nullable' ) .'|min:1';
                $rules['prices.'.$index] = 'bail|' . (!isset($variation_ids[$index]) ? 'required' : 'nullable' ) .'|numeric|min:'. $min .'|max:'. $max;
                $rules['main_files.'.$index] = 'bail|' . (!isset($variation_ids[$index]) ? 'required' : 'nullable' ) .'|exclude_if:file_types,Other|mimes:'.request()->get('file_types');
                $rules['variation_id.'.$index] = 'bail|nullable';
            }
        }

        $productType = ProductType::with('product_type_extensions')->find(request()->get('product_type_id'));
        $ifThumbnailRequired = $productType?->product_type_extensions->where('name', request()->get('file_types'))->first()?->thumbnail_required;
        if($ifThumbnailRequired == ACTIVE){
            $rules['thumbnail_image'] = 'bail|required|image|mimes:jpeg,jpg,png,gif,tif,bmp,ico,psd,webp';
        }

        if(!is_null($this->product) || !is_null($this->uuid)){
            $rules['main_file'] = 'bail|exclude_unless:accessibility,2|nullable|exclude_if:file_types,Other|mimes:'.request()->get('file_types');
            $rules['thumbnail_image'] = 'bail|nullable|image|mimes:jpeg,jpg,png,gif,tif,bmp,ico,psd,webp';
        }

        return $rules;
    }

    public function messages()
    {
        $max = (empty(getOption('product_price_max_limit')) ? 1:getOption('product_price_max_limit'));
        $min = (empty(getOption('product_price_min_limit')) ? 1:getOption('product_price_min_limit'));
        return [
            "tags.0.required" => __('This filed is required'),
            "variations.*.required" => __('This filed is required'),
            "prices.*.required" => __('Field is required'),
            "prices.*.numeric" => __('Field must be numeric'),
            "prices.*.min" => __('Field must be grater than ').$min,
            "prices.*.max" => __('Field must be less than ').$max,
            "main_files.*.required" => __('This filed is required'),
            "main_files.*.mimes" => __('Field must be type of ').request()->get('file_types'),
            "main_file.mimes" => __('This filed must be type of selected ').request()->get('file_types'),
        ];
    }
}
