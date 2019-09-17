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
     * Path for getting images through http
     *
     * @var string
     */
    private $publicPath;

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
        string $savePath = '%appDir%/../public/img/upload/$year/$month/',
        string $publicPath = '/img/upload/$year/$month/',
        string $cachePath = 'images/',
        $webpOptimization = true
    ) {
        $this->savePath = $savePath;
        $this->cachePath = $cachePath;
        $this->publicPath = $publicPath;
        $this->webpOptimization = $webpOptimization;
    }

    public function getSavePath(Image $image = null): string
    {
    	if ($image !== null) {
    		$this->savePath = str_replace([
    			'$year',
				'$month'
			], [
				$image->getCreatedAt()->format('Y'),
				$image->getCreatedAt()->format('m')
			], $this->savePath);
		}

		mkdir($this->savePath, 0755, true);

    	return $this->savePath;
    }

    public function getPublicPath(Image $image = null): string
    {
    	if ($image !== null) {
    		$this->publicPath = str_replace([
    			'$year',
				'$month'
			], [
				$image->getCreatedAt()->format('Y'),
				$image->getCreatedAt()->format('m')
			], $this->publicPath);
		}

    	return $this->publicPath;
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
