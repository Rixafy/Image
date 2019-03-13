<?php

declare(strict_types=1);

namespace Rixafy\Image;

class ImageConfig
{
    /**
     * Path for saving new images
     *
     * @var string
     */
    private $savePath;

    /**
     * Path for caching image in different sizes or WebP type
     *
     * @var string
     */
    private $cachePath;

    /**
     * Convert all PNG/JPEG to WebP format?
     *
     * @var bool
     */
    private $webpOptimization = true;

    public function __construct($savePath, $cachePath, $webpOptimization = true)
    {
        $this->savePath = $savePath;
        $this->cachePath = $cachePath;
        $this->webpOptimization = $webpOptimization;
    }

    /**
     * @return string
     */
    public function getSavePath(): string
    {
        return $this->savePath;
    }

    /**
     * @return string
     */
    public function getCachePath(): string
    {
        return $this->cachePath;
    }

    /**
     * @return bool
     */
    public function isWebpOptimization(): bool
    {
        return $this->webpOptimization;
    }
}