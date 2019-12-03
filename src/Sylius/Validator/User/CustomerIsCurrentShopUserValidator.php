<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\User;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class CustomerIsCurrentShopUserValidator extends ConstraintValidator
{
    /** @var LoggedInShopUserProviderInterface */
    private $loggedInShopUserProvider;

    public function __construct(LoggedInShopUserProviderInterface $loggedInShopUserProvider)
    {
        $this->loggedInShopUserProvider = $loggedInShopUserProvider;
    }

    public function validate($id, Constraint $constraint): void
    {
        if ($id !== $this->loggedInShopUserProvider->provide()->getId()) {
            $this->context->addViolation($constraint->message);
        }
    }
}
