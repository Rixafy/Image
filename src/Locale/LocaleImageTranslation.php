<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Doctrine\ORM\Mapping as ORM;
use Rixafy\DoctrineTraits\UniqueTrait;
use Rixafy\Image\ImageData;
use Rixafy\Image\ImageMetaTrait;
use Rixafy\Language\Language;

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
     * @ORM\ManyToOne(targetEntity="\Rixafy\Language\Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     * @var Language
     */
    private $language;

    /**
     * Many Translations have One Entity. Bidirectional.
     * @ORM\ManyToOne(targetEntity="\Rixafy\Image\LocaleImage\LocaleImage", inversedBy="translations")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     * @var LocaleImage
     */
    private $entity;

    public function __construct(ImageData $imageData, Language $language, LocaleImage $entity)
    {
        $this->language = $language;
        $this->entity = $entity;
        $this->description = $imageData->description;
        $this->title = $imageData->title;
        $this->alternative_text = $imageData->alternativeText;
    }
}
