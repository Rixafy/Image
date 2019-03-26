<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Doctrine\ORM\Mapping as ORM;
use Rixafy\Doctrination\Annotation\Translatable;
use Doctrine\Common\Collections\ArrayCollection;
use Rixafy\Doctrination\EntityTranslator;
use Rixafy\DoctrineTraits\ActiveTrait;
use Rixafy\DoctrineTraits\DateTimeTrait;
use Rixafy\DoctrineTraits\UniqueTrait;
use Rixafy\Image\Image;
use Rixafy\Image\ImagePropertiesTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="locale_image")
 */
class LocaleImage extends EntityTranslator
{
    use UniqueTrait;
    use ActiveTrait;
    use DateTimeTrait;
    use ImagePropertiesTrait;

    /**
     * @Translatable
     * @var string
     */
    private $url_name;

    /**
     * @Translatable
     * @var string
     */
    private $description;

    /**
     * @Translatable
     * @var string
     */
    private $title;

    /**
     * @Translatable
     * @var string
     */
    private $alternative_text;

    /**
     * One LocaleImage has Many Translations
     *
     * @ORM\OneToMany(targetEntity="\Rixafy\Image\LocaleImage\LocaleImageTranslation", mappedBy="entity", cascade={"persist", "remove"})
     * @var LocaleImageTranslation[]
     */
    protected $translations;

    public function __construct(LocaleImageData $localeImageData)
    {
        $this->translations = new ArrayCollection();

        $this->edit($localeImageData);
    }

    /**
     * @param LocaleImageData $imageData
     */
    public function edit(LocaleImageData $imageData)
    {
        $this->editTranslation($imageData);
    }

    /**
     * @return LocaleImageData
     */
    public function getData(): LocaleImageData
    {
        $data = new LocaleImageData();

        $data->urlName = $this->url_name;
        $data->description = $this->description;
        $data->title = $this->title;
        $data->alternativeText = $this->alternative_text;
        $data->realPath = $this->real_path;
        $data->width = $this->width;
        $data->height = $this->height;
        $data->fileExtension = $this->file_extension;
        $data->language = $this->translationLanguage;

        return $data;
    }

    /**
     * @return string
     */
    public function getUrlName(): string
    {
        return $this->url_name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getAlternativeText(): string
    {
        return $this->alternative_text;
    }

    public function getTranslations()
    {
        return $this->translations;
    }
}