<?php

namespace App\Contexts\Book\Domain\Events;

use App\Base\BaseDomainEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookDeletedEvent extends BaseDomainEvent
{
    use Dispatchable, SerializesModels;

    public int $bookId;

    public function __construct(int $bookId)
    {
        $this->bookId = $bookId;
    }
}
