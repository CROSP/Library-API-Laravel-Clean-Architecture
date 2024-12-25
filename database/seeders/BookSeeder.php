<?php

namespace Database\Seeders;
use App\Contexts\Book\Infrastructure\Eloquent\BookModel;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    private const NUMBER_OF_BOOKS = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();

        for ($i = 0; $i < self::NUMBER_OF_BOOKS; $i++) {
            BookModel::create([
                'title'             => $faker->sentence(3),
                'publisher'         => $faker->company,
                'author'            => $faker->name,
                'genre'             => $faker->word,
                'publication_date'  => $faker->date(),
                'pages'             => $faker->numberBetween(100, 1000),
                'price'             => $faker->randomFloat(2, 5, 50),
            ]);
        }
    }
}
