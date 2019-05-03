<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Doctrine\ORM\Mapping as ORM;
use Rixafy\DoctrineTraits\DateTimeTrait;
use Rixafy\DoctrineTraits\UniqueTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="image")
 */
class Image implements ImageInterface
{
    use UniqueTrait;
    use DateTimeTrait;
    use ImagePropertiesTrait;
    use ImageMetaTrait;

    public function __construct(ImageData $imageData)
    {
        $this->image_group = $imageData->imageGroup;
        $this->real_path = $imageData->realPath;
        $this->file_format = $imageData->fileFormat;

		[$this->width, $this->height] = getimagesize($imageData->file['tmp_name']);
		$this->file_extension = pathinfo($imageData->file['tmp_name'], PATHINFO_EXTENSION);

		$this->edit($imageData);
    }

    public function edit(ImageData $imageData): void
    {
        $this->alternative_text = $imageData->alternativeText;
        $this->title = $imageData->title;
        $this->description = $imageData->description;
    }

    public function getData(): ImageData
    {
        $data = new ImageData();

        $data->description = $this->description;
        $data->title = $this->title;
        $data->alternativeText = $this->alternative_text;
        $data->realPath = $this->real_path;
        $data->fileFormat = $this->file_format;

        return $data;
    }
}
