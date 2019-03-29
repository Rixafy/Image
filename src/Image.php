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
class Image
{
    use UniqueTrait;
    use DateTimeTrait;
    use ImagePropertiesTrait;
    use ImageMetaTrait;

    public function __construct(ImageData $imageData)
    {
        $this->image_group = $imageData->imageGroup;
        $this->real_path = $imageData->realPath;
        $this->width = $imageData->width;
        $this->height = $imageData->height;
        $this->file_format = $imageData->fileFormat;

        $this->edit($imageData);
    }

    /**
     * @param ImageData $imageData
     */
    public function edit(ImageData $imageData)
    {
        $this->url_name = $imageData->urlName;
        $this->alternative_text = $imageData->alternativeText;
        $this->title = $imageData->title;
        $this->description = $imageData->description;
    }

    /**
     * @return ImageData
     */
    public function getData(): ImageData
    {
        $data = new ImageData();

        $data->urlName = $this->url_name;
        $data->description = $this->description;
        $data->title = $this->title;
        $data->alternativeText = $this->alternative_text;
        $data->realPath = $this->real_path;
        $data->width = $this->width;
        $data->height = $this->height;
        $data->fileFormat = $this->file_format;
        $data->language = $this->translationLanguage;

        return $data;
    }

    /**
     * @return ImageTranslation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}