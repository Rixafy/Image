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
     * @param string $name
     * @param string $title
     * @param string $description
     * @param string $alternativeText
     * @param \Rixafy\Doctrination\Language\Language $language
     * @param Image $entity
     */
    public function __construct(string $name, string $description, string $title, string $alternativeText, Language $language, Image $entity)
    {
        $this->url_name = $name;
        $this->description = $description;
        $this->title = $title;
        $this->alternative_text = $alternativeText;
        $this->language = $language;
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getUrlName(): string
    {
        return $this->url_name;
    }

    /**
     * @param string $url_name
     */
    public function setUrlName(string $url_name): void
    {
        $this->url_name = $url_name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getAlternativeText(): string
    {
        return $this->alternative_text;
    }

    /**
     * @param string $alternative_text
     */
    public function setAlternativeText(string $alternative_text): void
    {
        $this->alternative_text = $alternative_text;
    }

    /**
     * @return \Rixafy\Doctrination\Language\Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * @param \Rixafy\Doctrination\Language\Language $language
     */
    public function setLanguage(Language $language): void
    {
        $this->language = $language;
    }
}