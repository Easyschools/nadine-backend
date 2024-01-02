<?php

namespace App\Http\Requests\MediaPress;

use Illuminate\Foundation\Http\FormRequest;

class MediaPressRequest extends FormRequest
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
            'name_ar' => 'required|min:2|max:50',
            'name_en' => 'required|min:2|max:50',
            'image' => 'required|image',
            'url' => 'nullable',
            'type' => 'nullable',
            
        ];
    }

    private function updateValidation()
    {
        return [
            'id' => 'required|exists:media_presses,id',
            'name_ar' => 'required|min:2|max:50',
            'name_en' => 'required|min:2|max:50',
            'image' => 'required|image',
            'url' => 'nullable',
            'type' => 'nullable',
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'required|exists:media_presses,id'
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
