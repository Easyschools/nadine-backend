<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'is_percentage' => 'required|boolean',
            'max_usage_per_order' => '',
            'max_usage_per_user' => '',
            'value' => 'required|min:1',
            'min_total' => 'required|min:1',
        ];
    }

    private function updateValidation()
    {
        return [
            'id' => 'required|exists:coupons,id',
            'is_percentage' => 'required|boolean',
            'max_usage_per_order' => '',
            'max_usage_per_user' => '',
            'value' => 'required|min:1',
            'min_total' => 'required|min:1',
            'type_ar' => 'required|min:1',
            'type_en' => 'required|min:1',
            'model_type' => 'required|min:1',
            'model_id' => 'required',
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'required|exists:coupons,id'
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
