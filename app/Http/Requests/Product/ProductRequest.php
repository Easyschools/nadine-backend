<?php

namespace App\Http\Requests\Product;

use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HelperFunctions;

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
            case 'edit':
            case 'update':
                return $this->updateValidation();
            case 'delete':
            case 'get':
                return $this->idValidation();
            case 'all':
                return $this->allValidation();
            case 'search':
                return $this->searchValidation();
            case 'import':
                return $this->importValidation();
            default:
                return [];
        }
    }

    private function createValidation()
    {
        return [
            'sku' => 'required|min:2',
            'name_en' => ['required', 'min:2', function ($attribute, $value, $fail) {
                $slug = HelperFunctions::makeSlug($this->name_en) . '-' . HelperFunctions::makeSlug($this->sku);
                if (Product::where('slug', $slug)->exists()) {
                    $fail("The combination name_en & sku should be unique.");
                }
            }],
            'name_ar' => 'required|min:2',
            'description_en' => 'required|min:2',
            'description_ar' => 'required|min:2',
            'material_id' => 'required|exists:materials,id',
            'collection_id' => 'nullable|exists:collections,id',
            //            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'price' => 'required|numeric|min:1',
            'price_after_discount' => 'required|numeric|min:0',
            'variants' => 'required|array',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.images' => 'required|array',
            'variants.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            //            'variants.*.dimension_id' => 'exists:dimensions,id',
            'variants.*.dimension' => 'nullable',
        ];
    }

    private function updateValidation()
    {
        return [
            'id' => 'required|exists:products,id',
            'sku' => 'required|min:2',
            'name_en' => ['required', 'min:2', function ($attribute, $value, $fail) {
                $slug = HelperFunctions::makeSlug($this->name_en) . '-' . HelperFunctions::makeSlug($this->sku);
                if (Product::where('slug', $slug)->where('id', '<>', $this->id)->exists()) {
                    $fail("The combination name_en & sku should be unique.");
                }
            }],
            'name_ar' => 'required|min:2',
            'description_en' => 'required|min:2',
            'description_ar' => 'required|min:2',
            'material_id' => 'required|exists:materials,id',
            'collection_id' => 'nullable|exists:collections,id',
            //            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'price' => 'required|numeric|min:1',
            'price_after_discount' => 'required|numeric|min:0',
            'variants' => 'required|array',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            //            'variants.*.dimension_id' => 'exists:dimensions,id',
            'variants.*.dimension_value' => 'nullable',
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'exists:products,id',
            'slug' => 'exists:products,slug',
        ];
    }

    private function allValidation()
    {
        return [
            'is_paginate' => 'in:0,1',
            'is_banned' => 'in:0,1',
        ];
    }

    private function searchValidation()
    {
        return
            [
                'search' => 'required|min:3'
            ];
    }

    private function importValidation()
    {
        return
            [
                'file' => 'required|file|mimes:xlsx,xls,csv'
            ];
    }
}
