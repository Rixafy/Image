<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Rixafy\Image\Group\ImageGroup;

trait ImagePropertiesTrait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $realPath;

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
     * @ORM\Column(type="string", length=5, nullable=true)
     * @var string
     */
    private $fileFormat;

    /**
     * @ORM\Column(type="string", length=5)
     * @var string
     */
    private $fileExtension;

    /**
     * Many Images have One ImageGroup
     *
     * @ORM\ManyToOne(targetEntity="\Rixafy\Image\Group\ImageGroup")
     * @var ImageGroup
     */
    private $imageGroup;

    public function getRealPath(): string
    {
        return $this->realPath;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getFileFormat(): string
    {
        return $this->fileFormat;
    }

	public function getFileExtension(): string
	{
		return $this->fileExtension;
	}

    public function getImageGroup(): ImageGroup
    {
        return $this->imageGroup;
    }
}
