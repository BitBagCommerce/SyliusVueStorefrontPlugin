<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetOrderHistoryAction
{
    public function __invoke(Request $request): Response
    {

        return VueStorefrontResponse::success($payload);
    }

}
