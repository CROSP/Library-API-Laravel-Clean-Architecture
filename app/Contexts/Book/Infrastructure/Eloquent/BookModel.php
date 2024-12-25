<?php

namespace App\Contexts\Book\Infrastructure\Eloquent;

use Database\Factories\BookModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'publisher',
        'author',
        'genre',
        'publication_date',
        'pages',
        'price'
    ];

    protected static function newFactory()
    {
        return BookModelFactory::new();
    }
}
