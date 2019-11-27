<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Mailer;

final class Emails
{
    public const EMAIL_VERIFICATION_TOKEN = 'api_verification_token';
    public const EMAIL_RESET_PASSWORD_TOKEN = 'api_reset_password_token';
    public const EMAIL_ORDER_CONFIRMATION = 'api_order_confirmation';

    private function __construct()
    {
    }
}
