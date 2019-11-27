<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

final class CreateCartRequest
{
    /** @var string|null */
    private $token;

    /** @var string */
    private $cartId;

    public function __construct(Request $request)
    {
        $this->token = $request->query->get('token');
        $this->cartId = Uuid::uuid4()->toString();
    }

    public static function fromHttpRequest(Request $request): self
    {
        return new self($request);
    }

    public function getCommand(): CreateCart
    {
        return new CreateCart($this->token, $this->cartId);
    }
}
