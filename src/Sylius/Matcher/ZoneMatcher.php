<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Matcher;

use Sylius\Component\Addressing\Model\Scope;
use Sylius\Component\Addressing\Model\ZoneInterface;
use Sylius\Component\Addressing\Model\ZoneMemberInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ZoneMatcher
{
    private const TYPE_COUNTRY = 'country';

    /** @var RepositoryInterface */
    private $zoneRepository;

    public function __construct(RepositoryInterface $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function match(string $countryCode, ?string $scope = null): ?ZoneInterface
    {
        $zones = [];

        /** @var ZoneInterface $zone */
        foreach ($this->getZones($scope) as $zone) {
            if ($this->addressBelongsToZone($countryCode, $zone)) {
                $zones[$zone->getType()] = $zone;
            }
        }

        if (isset($zones[self::TYPE_COUNTRY])) {
            return $zones[self::TYPE_COUNTRY];
        }

        return null;
    }

    private function addressBelongsToZone(string $countryCode, ZoneInterface $zone): bool
    {
        foreach ($zone->getMembers() as $member) {
            if ($this->addressBelongsToZoneMember($countryCode, $member)) {
                return true;
            }
        }

        return false;
    }

    private function addressBelongsToZoneMember(string $countryCode, ZoneMemberInterface $member): bool
    {
        switch ($type = $member->getBelongsTo()->getType()) {
            case ZoneInterface::TYPE_COUNTRY:
                return null !== $countryCode && $countryCode === $member->getCode();
            default:
                throw new \InvalidArgumentException(sprintf('Unexpected zone type "%s".', $type));
        }
    }

    private function getZones(?string $scope = null): array
    {
        if (null === $scope) {
            return $this->zoneRepository->findAll();
        }

        return $this->zoneRepository->findBy(['scope' => [$scope, Scope::ALL]]);
    }
}
