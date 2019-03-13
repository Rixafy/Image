<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Nette\Utils\Image as NetteImage;

class ImageRenderer
{
    /** @var ImageConfig */
    private $imageConfig;

    private const FORMATS = [NetteImage::JPEG => 'jpeg', NetteImage::PNG => 'png', NetteImage::GIF => 'gif', NetteImage::WEBP => 'webp'];

    public function __construct(ImageConfig $imageConfig)
    {
        $this->imageConfig = $imageConfig;
    }

    public function render(Image $image, int $resizeType = NetteImage::EXACT, $width = null, $height = null, $fileType = null): void
    {
        $extensions = array_flip(self::FORMATS) + ['jpg' => NetteImage::JPEG];

        if ($fileType == null) {
            $fileType = $extensions[$image->getFileExtension()];

            if ($fileType !== NetteImage::GIF && $this->imageConfig->isWebpOptimization()) {
                $fileType = NetteImage::WEBP;
            }
        }
    }
}