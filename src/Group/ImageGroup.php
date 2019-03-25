<?php

declare(strict_types=1);

namespace Rixafy\Image\ImageGroup;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function __construct(ImageGroupData $imageGroupData)
    {
        $this->images = new ArrayCollection();
        $this->edit($imageGroupData);
    }

    public function edit(ImageGroupData $imageGroupData)
    {
        $this->name = $imageGroupData->name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
    }
}