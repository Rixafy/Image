<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Rixafy\Doctrination\EntityTranslator;
use Rixafy\DoctrineTraits\ActiveTrait;
use Rixafy\DoctrineTraits\DateTimeTrait;
use Rixafy\DoctrineTraits\UniqueTrait;
use Rixafy\Image\Image;

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

    /**
     * @Translatable
     * @var string
     */
    protected $url_name;

    /**
     * @Translatable
     * @var string
     */
    protected $description;

    /**
     * @Translatable
     * @var string
     */
    protected $title;

    /**
     * @Translatable
     * @var string
     */
    protected $alternative_text;

    /**
     * One LocaleImage has One Image
     *
     * @ORM\ManyToOne(targetEntity="\Rixafy\Image\Image")
     * @var Image
     */
    private $image;

    /**
     * One LocaleImage has Many Translations
     *
     * @ORM\OneToMany(targetEntity="\Rixafy\Image\LocaleImage\LocaleImageTranslation", mappedBy="entity", cascade={"persist", "remove"})
     * @var LocaleImageTranslation[]
     */
    protected $translations;

    public function __construct(LocaleImageData $localeImageData, Image $image)
    {
        $this->translations = new ArrayCollection();
        $this->image = $image;

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
        $data->realPath = $this->image->getRealPath();
        $data->width = $this->image->getWidth();
        $data->height = $this->image->getHeight();
        $data->fileExtension = $this->image->getFileExtension();
        $data->language = $this->translationLanguage;

        return $data;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function getTranslations()
    {
        return $this->translations;
    }
}