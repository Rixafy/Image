<?php

declare(strict_types=1);

namespace Rixafy\Image;

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
    private $file_extension;

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
    public function getFileExtension(): string
    {
        return $this->file_extension;
    }
}