<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\CollectTotalsHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 * Class CollectTotalsHandlerSpec
 * @package spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart
 */
final class CollectTotalsHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CollectTotalsHandler::class);
    }
}
