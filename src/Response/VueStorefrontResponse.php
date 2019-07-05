<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class VueStorefrontResponse extends JsonResponse
{
    public static function success(Payload $payload): JsonResponse
    {
        return JsonResponse::create([
            'code' => $payload->getStatusCode(),
            'result' => $payload->getData(),
        ]);
    }

    public static function error(string $message): JsonResponse
    {
        return JsonResponse::create([
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'result' => $message,
        ]);
    }
}
