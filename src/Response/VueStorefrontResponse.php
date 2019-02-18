<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class VueStorefrontResponse extends JsonResponse
{
    public static function success(array $data): JsonResponse
    {
        return JsonResponse::create([
            'status' => Response::HTTP_OK,
            'result' => $data,
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
