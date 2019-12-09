<?php

declare(strict_types=1);

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

use Doctrine\Common\Collections\Collection;

interface CartPaymentMethodsViewFactoryInterface
{
    public function createList(Collection $payments): array;
}
