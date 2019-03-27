<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Doctrine\ORM\Mapping as ORM;
use Rixafy\Doctrination\Annotation\Translatable;
use Doctrine\Common\Collections\ArrayCollection;
use Rixafy\Doctrination\EntityTranslator;
use Rixafy\DoctrineTraits\DateTimeTrait;
use Rixafy\DoctrineTraits\UniqueTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="image")
 */
class Image extends EntityTranslator
{
    use UniqueTrait;
    use DateTimeTrait;
    use ImagePropertiesTrait;
    use ImageMetaTrait;

    /**
     * One Image has Many Translations
     *
     * @ORM\OneToMany(targetEntity="\Rixafy\Image\ImageTranslation", mappedBy="entity", cascade={"persist", "remove"})
     * @var ImageTranslation[]
     */
    protected $translations;

    public function __construct(ImageData $imageData)
    {
        $this->image_group = $imageData->imageGroup;
        $this->real_path = $imageData->realPath;
        $this->width = $imageData->width;
        $this->height = $imageData->height;
        $this->file_format = $imageData->fileFormat;
        $this->translations = new ArrayCollection();

        $this->edit($imageData);
    }

    /**
     * @param ImageData $imageData
     */
    public function edit(ImageData $imageData)
    {
        $this->editTranslation($imageData);
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