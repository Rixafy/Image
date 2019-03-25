<?php

declare(strict_types=1);

namespace Rixafy\Image\ImageGroup;

use Doctrine\ORM\Mapping as ORM;
use Rixafy\DoctrineTraits\ActiveTrait;
use Rixafy\DoctrineTraits\DateTimeTrait;
use Rixafy\DoctrineTraits\UniqueTrait;
use Rixafy\Image\Image;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="image_group")
 */
class ImageGroup
{
    use UniqueTrait;
    use ActiveTrait;
    use DateTimeTrait;

    /**
     * @ORM\Column(type="string", length=31)
     * @var string
     */
    private $name;

    /**
     * One ImageGroup has Many Images
     *
     * @ORM\OneToMany(targetEntity="\Rixafy\Image\Image", mappedBy="image_group", cascade={"persist", "remove"})
     * @var Image[]
     */
    private $images;


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}