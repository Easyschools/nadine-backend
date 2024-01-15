<?php

namespace App\Http\Requests\HighJewellery;

use Illuminate\Foundation\Http\FormRequest;

class CollectionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'design_target_desc' => 'required',
            'design_target_img' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }
}
