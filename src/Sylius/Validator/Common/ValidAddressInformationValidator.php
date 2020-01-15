<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Common;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidAddressInformationValidator extends ConstraintValidator
{
    private const ROUTE_SET_SHIPPING_INFORMATION = 'bitbag_vue_storefront_plugin_cart_set_shipping_information';
    private const ROUTE_CREATE_ORDER = 'bitbag_vue_storefront_plugin_order_create_order';

    /** @var RequestStack */
    private $requestStack;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(RequestStack $requestStack, ValidatorInterface $validator)
    {
        $this->requestStack = $requestStack;
        $this->validator = $validator;
    }

    public function validate($request, Constraint $constraint): void
    {
        $httpRequest = $this->requestStack->getCurrentRequest();

        $routeName = $httpRequest->attributes->get('_route');

        if ($routeName === self::ROUTE_SET_SHIPPING_INFORMATION) {
        } elseif ($routeName === self::ROUTE_CREATE_ORDER) {
            if (!$request->billingAddress) {
                $this->context->addViolation($constraint->message);
            } else {
                $this->validator->validate($request->billingAddress);
            }
        }
    }

}
