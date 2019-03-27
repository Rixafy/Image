<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Rixafy\Image\ImageGroup\ImageGroup;

trait ImagePropertiesTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $real_path;

    /**
     * @ORM\Column(type="smallint")
     * @var int
     */
    private $width;

    /**
     * @ORM\Column(type="smallint")
     * @var int
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=5)
     * @var string
     */
    private $file_format;

    /**
     * Many Images have One ImageGroup
     *
     * @ORM\ManyToOne(targetEntity="\Rixafy\Image\ImageGroup")
     * @var ImageGroup
     */
    private $image_group;

    /**
     * @return string
     */
    public function getRealPath(): string
    {
        return $this->real_path;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function getFileFormat(): string
    {
        return $this->file_format;
    }

    /**
     * @return ImageGroup
     */
    public function getImageGroup(): ImageGroup
    {
        return $this->image_group;
    }
}