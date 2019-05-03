<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Rixafy\Image\Group\ImageGroup;

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
     * @ORM\Column(type="string", length=5)
     * @var string
     */
    private $file_extension;

    /**
     * Many Images have One ImageGroup
     *
     * @ORM\ManyToOne(targetEntity="\Rixafy\Image\Group\ImageGroup")
     * @var ImageGroup
     */
    private $image_group;

    public function getRealPath(): string
    {
        return $this->real_path;
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
        return $this->file_format;
    }

	public function getFileExtension(): string
	{
		return $this->file_extension;
	}

    public function getImageGroup(): ImageGroup
    {
        return $this->image_group;
    }
}
