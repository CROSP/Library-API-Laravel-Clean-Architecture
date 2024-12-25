<?php
namespace App\Contexts\Book\Infrastructure\Persistence;

use App\Contexts\Book\Domain\Contracts\BookRepositoryContract;
use App\Contexts\Book\Infrastructure\Eloquent\BookModel;
use Illuminate\Support\Collection;

class EloquentBookRepository implements BookRepositoryContract
{
    public function create(array $attributes): BookModel
    {
        return BookModel::create($attributes);
    }

    public function findById(int $id): ?BookModel
    {
        return BookModel::find($id);
    }

    public function update(int $id, array $attributes): ?BookModel
    {
        $model = BookModel::find($id);
        if (!$model) {
            return null;
        }

        $model->update($attributes);
        return $model;
    }

    public function delete(int $id): bool
    {
        $model = BookModel::find($id);
        if (!$model) {
            return false;
        }
        return (bool)$model->delete();
    }

    public function getAll(): Collection
    {
        return BookModel::all();
    }
}
