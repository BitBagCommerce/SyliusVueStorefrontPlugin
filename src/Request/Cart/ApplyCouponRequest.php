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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\ApplyCoupon;
use Symfony\Component\HttpFoundation\Request;

final class ApplyCouponRequest
{
    /** @var string|null */
    private $token;

    /** @var int|string */
    private $cartId;

    /** @var string */
    private $coupon;

    public function __construct(Request $request)
    {
        $this->token = $request->query->get('token');
        $this->cartId = $request->query->get('cartId');
        $this->coupon = $request->query->get('coupon');
    }

    public static function fromHttpRequest(Request $request): self
    {
        return new self($request);
    }

    public function getCommand(): ApplyCoupon
    {
        return new ApplyCoupon($this->token, $this->cartId, $this->coupon);
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getCoupon(): string
    {
        return $this->coupon;
    }
}
