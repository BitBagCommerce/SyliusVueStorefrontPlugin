<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\User;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ShopUserCheckCorrectIdValidator extends ConstraintValidator
{
    /** @var LoggedInShopUserProviderInterface */
    private $loggedInShopUserProvider;

    public function __construct(LoggedInShopUserProviderInterface $loggedInShopUserProvider)
    {
        $this->loggedInShopUserProvider = $loggedInShopUserProvider;
    }

    public function validate($id, Constraint $constraint)
    {
        if ($id !== $this->loggedInShopUserProvider->provide()->getId()) {
            $this->context->addViolation($constraint->message);
        }
    }
}
