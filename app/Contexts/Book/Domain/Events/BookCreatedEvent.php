<?php

namespace App\Contexts\Book\Domain\Events;

use App\Base\BaseDomainEvent;
use App\Contexts\Book\Domain\Entities\BookEntity;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookCreatedEvent extends BaseDomainEvent
{
    use Dispatchable, SerializesModels;

    public BookEntity $book;

    public function __construct(BookEntity $book)
    {
        $this->book = $book;
    }
}
