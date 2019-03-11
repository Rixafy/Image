<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Doctrine\ORM\Mapping as ORM;
use Rixafy\Doctrination\Language\Language;
use Rixafy\DoctrineTraits\UniqueTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_translation", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"entity_id", "language_id"})
 * })
 */
class ImageTranslation
{
    use UniqueTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $url_name;

    /**
     * @ORM\Column(type="string", length=1023)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $alternative_text;

    /**
     * Many Translations have One Language. Unidirectional.
     * @ORM\ManyToOne(targetEntity="\Rixafy\Doctrination\Language\Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     * @var \Rixafy\Doctrination\Language\Language
     */
    private $language;

    /**
     * Many Translations have One Entity. Bidirectional.
     * @ORM\ManyToOne(targetEntity="\Rixafy\Image\Image", inversedBy="translations")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     * @var Image
     */
    private $entity;

    /**
     * ImageTranslation constructor.
     * @param ImageData $imageData
     * @param \Rixafy\Doctrination\Language\Language $language
     * @param Image $entity
     */
    public function __construct(ImageData $imageData, Language $language, Image $entity)
    {
        $this->language = $language;
        $this->entity = $entity;
        $this->url_name = $imageData->urlName;
        $this->description = $imageData->description;
        $this->title = $imageData->title;
        $this->alternative_text = $imageData->alternativeText;
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
    public function getTitle(): string
    {
        return $this->title;
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
    public function getAlternativeText(): string
    {
        return $this->alternative_text;
    }
}