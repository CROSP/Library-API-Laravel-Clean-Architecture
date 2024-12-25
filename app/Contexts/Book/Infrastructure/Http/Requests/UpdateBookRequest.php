<?php

namespace App\Contexts\Book\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'publisher' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:100',
            'publication_date' => 'sometimes|date',
            'pages' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0',
        ];
    }
}
