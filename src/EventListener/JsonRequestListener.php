<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\EventListener;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonRequestListener
{
    public function convertJsonStringToArray(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        if ('json' !== $request->getContentType() || !$request->getContent()) {
            return;
        }

        $data = json_decode($request->getContent(), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadRequestHttpException('Invalid json body: ' . json_last_error_msg());
        }

        $request->request->replace(is_array($data) ? $data : []);
    }
}
