<?php

namespace App\Contexts\Book\Application;

use App\Contexts\Book\Application\Exception\BookPriceValidationException;
use App\Contexts\Book\Domain\Contracts\BookMapperContract;
use App\Contexts\Book\Domain\Contracts\BookRepositoryContract;
use App\Contexts\Book\Domain\Entities\BookEntity;
use App\Contexts\Book\Domain\Events\BookCreatedEvent;
use App\Contexts\Book\Domain\Events\BookDeletedEvent;
use App\Contexts\Book\Domain\Events\BookUpdatedEvent;
use App\Contexts\Book\Infrastructure\Eloquent\BookModel;

class BookService
{
    private BookRepositoryContract $bookRepo;
    private BookMapperContract $mapper;
    const MAX_BOOK_PRICE = 99999;

    public function __construct(BookRepositoryContract $bookRepo, BookMapperContract $mapper)
    {
        $this->bookRepo = $bookRepo;
        $this->mapper = $mapper;
    }

    /**
     * Business logic for creating a book
     */
    public function createBook(BookEntity $book): BookEntity
    {
        $this->validateBookPrice($book);

        $attributes = $this->mapper->entityToModel($book);
        $model = $this->bookRepo->create($attributes);
        $createdBook = $this->mapper->modelToEntity($model);

        event(new BookCreatedEvent($createdBook));

        return $createdBook;
    }

    /**
     * Retrieve a single Book
     */
    public function getBook(int $id): ?BookEntity
    {
        $model = $this->bookRepo->findById($id);
        if (!$model) {
            return null;
        }
        return $this->mapper->modelToEntity($model);
    }

    /**
     * Update a Book
     */
    public function updateBook(int $id, BookEntity $updatedBook): ?BookEntity
    {
        $this->validateBookPrice($updatedBook);

        $attributes = $this->mapper->entityToModel($updatedBook);
        $model = $this->bookRepo->update($id, $attributes);
        if (!$model) {
            return null;
        }

        $entity = $this->mapper->modelToEntity($model);
        event(new BookUpdatedEvent($entity));

        return $entity;
    }

    /**
     * Delete a Book
     */
    public function deleteBook(int $id): bool
    {
        $deleted = $this->bookRepo->delete($id);
        if ($deleted) {
            event(new BookDeletedEvent($id));
        }

        return $deleted;
    }

    /**
     * List all Books
     */
    public function listBooks(): array
    {
        $models = $this->bookRepo->getAll();
        return $models->map(fn(BookModel $model) => $this->mapper->modelToEntity($model))->toArray();
    }

    /**
     * Validate the price of the book
     */
    private function validateBookPrice(BookEntity $book): void
    {
        if ($book->getPrice() < 0 || $book->getPrice() > self::MAX_BOOK_PRICE) {
            throw new BookPriceValidationException(__("error.book.price_invalid"));
        }
    }
}
