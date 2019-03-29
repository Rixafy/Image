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
     * Path for caching images, for instance "../thumbs"
     *
     * @var string
     */
    private $cachePath;

    /**
     * Path for viewing images through website, for instance "/thumbs"
     *
     * @var string
     */
    private $webPath;

    /**
     * Convert all PNG/JPEG to WebP format?
     *
     * @var bool
     */
    private $webpOptimization;

    public function __construct(
        string $savePath = 'img/upload',
        string $cachePath = 'image',
        string $webPath = 'image',
        $webpOptimization = true
    ) {
        $this->savePath = $savePath;
        $this->webPath = $webPath;
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
     * @return string
     */
    public function getWebPath(): string
    {
        return $this->webPath;
    }

    /**
     * @return bool
     */
    public function isWebpOptimization(): bool
    {
        return $this->webpOptimization;
    }
}