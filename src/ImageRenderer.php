<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Nette\Utils\Image as NetteImage;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;

class ImageRenderer
{
    /** @var ImageConfig */
    private $imageConfig;

    /** @var array */
    private const FORMATS = [NetteImage::JPEG => 'jpeg', NetteImage::PNG => 'png', NetteImage::GIF => 'gif', NetteImage::WEBP => 'webp'];

    public function __construct(ImageConfig $imageConfig)
    {
        $this->imageConfig = $imageConfig;
    }

    /**
     * @param Image $image
     * @param int $resizeType
     * @param int|string $width Width in pixels or percentage
     * @param int|string $height Height in pixels or percentage
     * @param null $fileType
     * @throws ImageException
     */
    public function render(Image $image, int $resizeType = NetteImage::EXACT, $width = null, $height = null, $fileType = null): void
    {
        $extensions = array_flip(self::FORMATS) + ['jpg' => NetteImage::JPEG];

        if ($fileType == null) {
            $fileType = $extensions[$image->getFileExtension()];

            if ($fileType !== NetteImage::GIF && $this->imageConfig->isWebpOptimization()) {
                $fileType = NetteImage::WEBP;
            }
        }

        $percentageOrPixels = strpos($width, '%') !== false ? 'p' : 'x';
        $tmpPath = $this->imageConfig->getCachePath() . '/' . $fileType . '/' . (int) $width . $percentageOrPixels . (int) $height . '/' . (string) $image->getId() . self::FORMATS[$fileType];

        try {
            $image = NetteImage::fromFile($tmpPath);
            $image->send($fileType);

        } catch (UnknownImageFileException | ImageException $e) {
            try {
                $originalImage = NetteImage::fromFile($image->getRealPath());
                $originalImage->resize($width, $height, $resizeType);
                $originalImage->save($tmpPath, NetteImage::PNG ? 1 : 100, $fileType);
                $originalImage->send($fileType);

            } catch (UnknownImageFileException | ImageException $e) {
                $blank = NetteImage::fromBlank(200, 200, NetteImage::rgb(16, 16, 16));
                $blank->save($tmpPath);
                $blank->send();
            }
        }
    }
}