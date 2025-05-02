<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductValidationRequest extends FormRequest
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
        $product = $this->route('product_id');
        return [
            'productImages'         =>  ['required','array'],  
            'deletedImagesIds'      =>  ['nullable','array'],
            'backendImages'         =>  ['nullable','array'],
            'productName'           =>  ['required','string'],
            'englishName'           =>  ['required','string'],
            'slug'                  =>  ['required','string', $product ? Rule::unique('products', 'slug')->ignore($product): Rule::unique('products', 'slug'),] ,
            'productPrice'          =>  ['required','integer'],
            'productWeight'         =>  ['required','integer'],
            'productWeightDesc'     =>  ['required','string'],
            'productCategory'       =>  ['nullable','string'],
            'productMaxQuantity'    =>  ['required','integer'],
            'metaTitle'             =>  ['required','string'],
            'metaKeyword'           =>  ['required','string'],
            'metaDescription'       =>  ['required','string'],
            'productSortDesc'       =>  ['nullable','string'],
            'productLongDesc'       =>  ['nullable','string'],
            'productStatus'         =>  ['nullable'],
        ];
    }
}
