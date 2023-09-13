<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentTypeRequest extends FormRequest
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
            default:
                return [];
        }
    }

    private function createValidation()
    {
        return [
            'name_en' => 'required|min:2|unique:payment_types,name_en',
            'name_ar' => 'required|min:2|unique:payment_types,name_ar',
            'image' => 'required',
        ];
    }

    private function updateValidation()
    {
        return [
            'name_en' => 'required|min:2|unique:payment_types,name_en' . $this->id,
            'name_ar' => 'required|min:2|unique:payment_types,name_ar' . $this->id,
            'image' => 'required',
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'required|exists:payment_types,id'
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
