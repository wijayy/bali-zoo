<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'required',
            'price'=> 'required|integer',
            'stock'=> 'required|integer',
            'length'=> 'required|integer',
            'width'=> 'required|integer',
            'height'=> 'required|integer',
            'weight'=> 'required|integer',
            'category_id'=> 'required',
            'image1'=> 'nullable|file|image',
            'image2'=> 'nullable|file|image',
            'image3'=> 'nullable|file|image',
            'image4'=> 'nullable|file|image',
            'image5'=> 'nullable|file|image',
        ];
    }
}
