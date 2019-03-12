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
     * Convert all PNG/JPEG to WebP format?
     *
     * @var bool
     */
    private $webpOptimization = true;

    public function __construct($savePath, $webpOptimization = true)
    {
        $this->savePath = $savePath;
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
     * @return bool
     */
    public function isWebpOptimization(): bool
    {
        return $this->webpOptimization;
    }
}