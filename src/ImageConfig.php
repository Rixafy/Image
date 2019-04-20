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
     * Convert all PNG/JPEG to WebP format?
     *
     * @var bool
     */
    private $webpOptimization;

    public function __construct(
        string $savePath = 'img/upload',
        string $cachePath = 'images',
        $webpOptimization = true
    ) {
        $this->savePath = $savePath;
        $this->cachePath = $cachePath;
        $this->webpOptimization = $webpOptimization;
    }

    public function getSavePath(): string
    {
        return $this->savePath;
    }

    public function getCachePath(): string
    {
        return $this->cachePath;
    }

    public function isWebpOptimization(): bool
    {
        return $this->webpOptimization;
    }
}
