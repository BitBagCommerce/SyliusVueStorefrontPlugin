<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingInformation;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SetShippingInformationHandler implements MessageHandlerInterface
{
    public function __construct()
    {

    }

    public function __invoke(SetShippingInformation $setShippingInformation): void
    {
    }
}
