<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\CreateUserHandler;
use PhpSpec\ObjectBehavior;

class CreateUserHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CreateUserHandler::class);
    }
}
