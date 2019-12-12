<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CreateCartFactory;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

final class CreateCartRequest implements RequestInterface
{
    /** @var string|null */
    public $token;

    /** @var string */
    public $cartId;

    public function __construct(Request $request)
    {
        $this->token = $request->query->get('token');
        //$this->cartId = Uuid::uuid4()->toString();
    }

    public static function fromHttpRequest(Request $request): self
    {
        return new self($request);
    }

    public function getCommand(): CreateCart
    {
        //return new CreateCart($this->token, $this->cartId);
        return (new CreateCartFactory())->createFromDTO($this);
    }
}
