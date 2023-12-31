<?php

namespace App\Http\Requests\Region;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
            'is_default' => 'required|in:0,1',
            'name_ar' => 'required|min:2',
            'code' => 'required|min:1',
        ];
    }

    private function updateValidation()
    {
        return [
            'id' => 'required|exists:countries,id',
            'name_en' => 'required|min:2',
            'is_default' => 'required|in:0,1',
            'name_ar' => 'required|min:2',
            'code' => 'required|min:1|unique:countries,id,' . $this->id,
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'required|exists:countries,id'
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
