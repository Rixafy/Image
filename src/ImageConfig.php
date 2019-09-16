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
        string $savePath = '%appDir%/../public/img/upload/',
        string $cachePath = 'images/',
        $webpOptimization = true
    ) {
        $this->savePath = $savePath;
        $this->cachePath = $cachePath;
        $this->webpOptimization = $webpOptimization;
    }

    public function getSavePath(Image $image = null): string
    {
    	if ($image === null) {
			return $this->savePath;
		} else {
    		return str_replace([
    			'%year%',
				'%month%'
			], [
				$image->getCreatedAt()->format('Y'),
				$image->getCreatedAt()->format('m')
			], $this->savePath);
		}
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
