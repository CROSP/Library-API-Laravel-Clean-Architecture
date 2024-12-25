<?php

namespace App\Contexts\User\Domain\Events;

use App\Base\BaseDomainEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedInEvent extends BaseDomainEvent
{
    use Dispatchable, SerializesModels;

    public string $userEmail;
    public string $userToken;

    public function __construct(string $userEmail, string $userToken)
    {
        $this->userEmail = $userEmail;
        $this->userToken = $userToken;
    }
}
