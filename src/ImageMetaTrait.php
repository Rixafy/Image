<?php

declare(strict_types=1);

namespace Rixafy\Image;

trait ImageMetaTrait
{
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     * @var string
     */
    private $alternativeText;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAlternativeText(): string
    {
        return $this->alternativeText;
    }
}
