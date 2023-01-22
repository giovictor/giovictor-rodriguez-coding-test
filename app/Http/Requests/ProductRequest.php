<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];

        if($this->has('name') && $this->has('description') && $this->has('price')) {
            $rules = [
                'name' => 'required|max:255',
                'description' => 'required',
                'price' => 'required|decimal:2'
            ];
        }

        if($this->has('page') && $this->has('limit')) {
            $rules = [
                'page' => 'numeric',
                'limit' => 'numeric',
            ];
        }

        return $rules;
    }
}
