<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\ChangePasswordHandler;
use PhpSpec\ObjectBehavior;

class ChangePasswordHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ChangePasswordHandler::class);
    }
}
