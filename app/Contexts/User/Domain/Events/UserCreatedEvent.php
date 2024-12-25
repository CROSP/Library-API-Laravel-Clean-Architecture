<?php

namespace App\Contexts\User\Domain\Events;

use App\Base\BaseDomainEvent;
use App\Contexts\User\Domain\Entities\UserEntity;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreatedEvent extends BaseDomainEvent
{
    use Dispatchable, SerializesModels;

    public UserEntity $user;

    public function __construct(UserEntity $user)
    {
        $this->user = $user;
    }
}
