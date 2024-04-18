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
                case 'get-variants':
                    return $this->getVariantsValidation();
                
            case 'all':
                return $this->allValidation();
            case 'search':
                return $this->searchValidation();
            case 'import':
                return $this->importValidation();
            case 'getSubProduct':
                return $this->getSubProduct();
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
            // 'material_id' => 'required|exists:materials,id',
            'collection_id' => 'nullable|exists:collections,id',
            //            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'price' => 'required|numeric|min:1',
            'limited_edition' => 'nullable|numeric',
            'best_selling' => 'nullable|numeric',
            'price_after_discount' => 'required|numeric|min:0',
            'files' => 'nullable',
            'variants' => 'required|array',
            'variants.*.color_id' => 'nullable|array',
            'variants.*.color_id.*.id' => 'nullable',
            // 'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.material_id' => 'nullable|exists:materials,id',

            // 'variants.*.images' => 'nullable|array',
            // 'variants.*.images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'variants.*.dimension' => 'nullable',
            'variants.*.additional_price' => 'required|numeric',

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
            // 'material_id' => 'required|exists:materials,id',
            'collection_id' => 'nullable|exists:collections,id',
            //            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'price' => 'required|numeric|min:1',
            'limited_edition' => 'nullable|numeric',
            'best_selling' => 'nullable|numeric',
            'price_after_discount' => 'required|numeric|min:0',
            'files' => 'nullable',
            'variants' => 'required|array',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.material_id' => 'nullable|exists:materials,id',

            // 'variants.*.images' => 'nullable|array',
            // 'variants.*.images.*' => 'image',
            // 'variants.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'variants.*.dimension_value' => 'nullable',
            'variants.*.additional_price' => 'required|numeric',
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
    
    private function getVariantsValidation()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'material_id' => 'required|exists:materials,id',
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
    private function getSubProduct()
    {
        return
            [
                'id' => ['required', 'exists:products,id']
            ];
    }
}
