<?php
namespace App\Contexts\Book\Domain\Contracts;

use App\Contexts\Book\Domain\Entities\BookEntity;
use App\Contexts\Book\Infrastructure\Eloquent\BookModel;

interface BookMapperContract
{
    public function entityToModel(BookEntity $entity): array;
    public function modelToEntity(BookModel $model): BookEntity;
}
