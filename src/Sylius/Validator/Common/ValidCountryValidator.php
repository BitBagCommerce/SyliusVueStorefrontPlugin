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

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ValidCountryValidator extends ConstraintValidator
{
    public function validate($request, Constraint $constraint): void
    {
        if (($request->country_id === null) && ($request->countryId === null)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
