<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Doctrine\ORM\Mapping as ORM;
use Rixafy\Doctrination\Language\Language;
use Rixafy\DoctrineTraits\UniqueTrait;
use Rixafy\Image\ImageMetaTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="locale_image_translation", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"entity_id", "language_id"})
 * })
 */
class LocaleImageTranslation
{
    use UniqueTrait;
    use ImageMetaTrait;

    /**
     * Many Translations have One Language. Unidirectional.
     * @ORM\ManyToOne(targetEntity="\Rixafy\Doctrination\Language\Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     * @var \Rixafy\Doctrination\Language\Language
     */
    private $language;

    /**
     * Many Translations have One Entity. Bidirectional.
     * @ORM\ManyToOne(targetEntity="\Rixafy\Image\LocaleImage\LocaleImage", inversedBy="translations")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     * @var LocaleImage
     */
    private $entity;

    /**
     * ImageTranslation constructor.
     * @param LocaleImageData $imageData
     * @param \Rixafy\Doctrination\Language\Language $language
     * @param LocaleImage $entity
     */
    public function __construct(LocaleImageData $imageData, Language $language, LocaleImage $entity)
    {
        $this->language = $language;
        $this->entity = $entity;
        $this->url_name = $imageData->urlName;
        $this->description = $imageData->description;
        $this->title = $imageData->title;
        $this->alternative_text = $imageData->alternativeText;
    }
}