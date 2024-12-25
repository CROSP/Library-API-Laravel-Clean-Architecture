<?php

namespace App\Contexts\Book\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'             => 'required|string|max:255',
            'publisher'         => 'required|string|max:255',
            'author'            => 'required|string|max:255',
            'genre'             => 'required|string|max:100',
            'publication_date'  => 'required|date',
            'pages'             => 'required|integer|min:1',
            'price'             => 'required|numeric|min:0',
        ];
    }
}
