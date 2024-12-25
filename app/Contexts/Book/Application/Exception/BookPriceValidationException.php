<?php

namespace App\Contexts\Book\Application\Exception;

use App\Base\Exceptions\BaseDomainException;

class BookPriceValidationException extends BaseDomainException
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }

    public function getLoggableMessage()
    {
        return __("exception.prefix") . $this->getMessage();
    }
}
