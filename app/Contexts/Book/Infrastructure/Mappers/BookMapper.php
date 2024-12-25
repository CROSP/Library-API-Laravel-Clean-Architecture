<?php

namespace App\Contexts\Book\Infrastructure\Mappers;

use App\Contexts\Book\Domain\Contracts\BookMapperContract;
use App\Contexts\Book\Domain\Entities\BookEntity;
use App\Contexts\Book\Infrastructure\Eloquent\BookModel;

class BookMapper implements BookMapperContract
{
    public function entityToModel(BookEntity $entity): array
    {
        return [
            'title' => $entity->getTitle(),
            'publisher' => $entity->getPublisher(),
            'author' => $entity->getAuthor(),
            'genre' => $entity->getGenre(),
            'publication_date' => $entity->getPublicationDate(),
            'pages' => $entity->getPages(),
            'price' => $entity->getPrice(),
        ];
    }

    public function modelToEntity(BookModel $model): BookEntity
    {
        return new BookEntity(
            $model->title,
            $model->publisher,
            $model->author,
            $model->genre,
            $model->publication_date,
            $model->pages,
            $model->price,
            $model->id,
        );
    }
}
