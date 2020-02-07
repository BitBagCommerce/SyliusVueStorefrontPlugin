<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product\MediaGallery;

class Media implements \JsonSerializable
{
    private const IMAGE_PATH = 'image';

    private const POSITION = 'pos';

    private const TYPE = 'typ';

    //    TODO MEDIA -> VID, LAB? image_path & id are only fields in integration boilerplate
    private const VID = 'vid';

    private const LAB = 'lab';

    private const ID = 'id';

    /** @var string */
    private $imagePath;

    /** @var int */
    private $position;

    /** @var string */
    private $type;

    /** @var mixed|null */
    private $vid = false;

    /** @var string */
    private $lab = '';

    /** @var int */
    private $id;

    public function __construct(string $imagePath, int $position, string $type, int $id)
    {
        $this->imagePath = $imagePath;
        $this->position = $position;
        $this->type = $type;
        $this->id = $id;
    }

    public function jsonSerialize(): array
    {
        return [
            self::IMAGE_PATH => $this->imagePath,
            self::POSITION => $this->position,
            self::TYPE => $this->type,
            self::VID => $this->vid,
            self::LAB => $this->lab,
            self::ID => $this->id,
        ];
    }
}
