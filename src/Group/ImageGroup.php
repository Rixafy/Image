<?php

declare(strict_types=1);

namespace Rixafy\Image\Group;

use Doctrine\ORM\Mapping as ORM;
use Rixafy\DoctrineTraits\DateTimeTrait;
use Rixafy\DoctrineTraits\UniqueTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="image_group")
 */
class ImageGroup
{
    use UniqueTrait;
    use DateTimeTrait;

    /**
     * @ORM\Column(type="string", length=31)
     * @var string
     */
    private $name;

    public function __construct(ImageGroupData $imageGroupData)
    {
        $this->edit($imageGroupData);
    }

    public function edit(ImageGroupData $imageGroupData): void
    {
        $this->name = $imageGroupData->name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}