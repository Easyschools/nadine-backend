<?php

namespace App\Http\Requests\Product;

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
     * @return array
     */
    public function rules()
    {
        $k = count($this->segments());
        $endPoint = $this->segment($k);
        switch ($endPoint) {
            case 'create':
                return $this->createValidation();
            case 'update':
                return $this->updateValidation();
            case 'delete':
            case 'get':
                return $this->idValidation();
            case 'all':
                return $this->allValidation();
            default:
                return [];
        }
    }

    private function createValidation()
    {
        return [
            'name_en' => 'required|min:2',
            'sku' => 'required|min:2',
            'name_ar' => 'required|min:2',
            'description_en' => 'required|min:2',
            'description_ar' => 'required|min:2',
            'material_id' => 'required|exists:materials,id',
            'collection_id' => 'nullable|exists:collections,id',
            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'price' => 'required|numeric|min:1',
            'price_after_discount' => 'required|numeric|min:1',
            'variants' => 'required|array',
            'variants.*.color_id' => 'exists:colors,id',
            'variants.*.dimension_id' => 'exists:dimensions,id',
            'variants.*.stock' => 'required',
        ];
    }

    private function updateValidation()
    {
        return [
            'id' => 'required|exists:products,id',
            'sku' => 'required|min:2',
            'name_ar' => 'required|min:2',
            'description_en' => 'required|min:2',
            'description_ar' => 'required|min:2',
            'material_id' => 'required|exists:materials,id',
            'collection_id' => 'nullable|exists:collections,id',
            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'price' => 'required|numeric|min:1',
            'price_after_discount' => 'required|numeric|min:1',
            'variants' => 'required|array',
            'variants.*.color_id' => 'exists:colors,id',
            'variants.*.dimension_id' => 'exists:dimensions,id',
            'variants.*.stock' => 'required',
        ];
    }

    private function idValidation()
    {
        return [
//            'id' => 'required|exists:products,id',
            'slug' => 'required|exists:products,slug'
        ];
    }

    private function allValidation()
    {
        return [
            'is_paginate' => 'in:0,1',
            'is_banned' => 'in:0,1',
        ];
    }

}
