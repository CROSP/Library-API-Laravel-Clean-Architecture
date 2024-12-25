<?php

namespace Database\Factories;

use App\Contexts\Book\Infrastructure\Eloquent\BookModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\AppContextsBookInfrastructureEloquentBookModel>
 */
class BookModelFactory extends Factory
{
    protected $model = BookModel::class;

    public function definition()
    {
        return [
            'title'             => $this->faker->sentence(3),
            'publisher'         => $this->faker->company,
            'author'            => $this->faker->name,
            'genre'             => $this->faker->word,
            'publication_date'  => $this->faker->date(),
            'pages'             => $this->faker->numberBetween(100, 1000),
            'price'             => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
