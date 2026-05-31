<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'    => 'sometimes|nullable|integer',
            'subcategory_id' => 'sometimes|nullable|integer',
            'author_id'      => 'sometimes|nullable|integer',
            'title'          => 'sometimes|required|string|max:255',
            'slug'           => 'sometimes|nullable|string|max:255',
            'description'    => 'sometimes|nullable|string',
            'location'       => 'sometimes|nullable|string|max:255',
            'suburb'         => 'sometimes|nullable|string|max:255',
            'price_offer'    => 'sometimes|nullable|numeric|min:0',
            'type'           => 'sometimes|nullable|string|max:100',
            'status'         => 'sometimes|nullable|string|max:100',
            'photos'         => 'sometimes|nullable|array',
        ];
    }
}
