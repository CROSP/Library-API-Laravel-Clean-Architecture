<?php

namespace App\Contexts\Book\Domain\Contracts;

use App\Contexts\Book\Infrastructure\Eloquent\BookModel;
use Illuminate\Support\Collection;

interface BookRepositoryContract
{
    public function create(array $attributes): BookModel;
    public function findById(int $id): ?BookModel;
    public function update(int $id, array $attributes): ?BookModel;
    public function delete(int $id): bool;
    public function getAll(): Collection;
}
