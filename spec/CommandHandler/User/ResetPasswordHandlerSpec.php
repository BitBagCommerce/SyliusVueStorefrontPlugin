<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\ResetPasswordHandler;
use PhpSpec\ObjectBehavior;

class ResetPasswordHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ResetPasswordHandler::class);
    }
}
