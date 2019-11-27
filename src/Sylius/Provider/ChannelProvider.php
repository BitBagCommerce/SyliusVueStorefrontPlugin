<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;

final class ChannelProvider
{
    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    /** @var string */
    private $channelCode;

    public function __construct(ChannelRepositoryInterface $channelRepository, string $channelCode)
    {
        $this->channelRepository = $channelRepository;
        $this->channelCode = $channelCode;
    }

    public function provide(): ChannelInterface
    {
        return $this->channelRepository->findOneByCode($this->channelCode);
    }
}
