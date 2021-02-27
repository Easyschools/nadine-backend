<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            case 'all':
                return $this->allValidation();
            case 'get':
                return $this->getValidation();
            case 'update':
                return $this->updateValidation();
            case 'get-complain':
                return $this->getComplain();
            case 'delete':
                return $this->deleteValidation();
            default:
                return [];
        }
    }

    private function getValidation()
    {
        return [
            'id' => 'exists:users,id'
        ];
    }

    private function getComplain()
    {
        return [
            'complain_id' => 'exists:complains,id'
        ];
    }

    private function updateValidation()
    {
        $id = Auth::id();
        return [
            'user_id' => 'exists:users,id',
            'name' => 'min:2|max:100',
            'image' => 'mimes:jpeg,jpg,png|image',
            'phone' => 'unique:users,phone,' . $id,
            'addresses' => 'array',
            'addresses.*.city_id' => 'nullable|integer|exists:cities,id',
            'addresses.*.address' => 'nullable|min:2',
        ];
    }

    private function deleteValidation()
    {
        return [
            'id' => 'required|exists:users,id'
        ];
    }

    private function allValidation()
    {
        return [
            'is_paginate' => 'in:1,0'
        ];
    }


}