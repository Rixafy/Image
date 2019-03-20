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
        $this->getImage($image, $resizeType, $width, $height, $fileType)->send();
    }

    public function getImage(Image $image, int $resizeType = NetteImage::EXACT, $width = null, $height = null, $fileType = null): NetteImage
    {
        $tmpPath = $this->getImagePath($image, $resizeType, $width, $height, $fileType);

        try {
            return NetteImage::fromFile($tmpPath);

        } catch (UnknownImageFileException $e) {
            try {
                $renderImage = NetteImage::fromFile($image->getRealPath());
                $renderImage->resize($width, $height, $resizeType);
                $renderImage->save($tmpPath, NetteImage::PNG ? 1 : 100, $fileType);

            } catch (UnknownImageFileException | ImageException $e) {
                $renderImage = NetteImage::fromBlank(200, 200, NetteImage::rgb(16, 16, 16));
                $renderImage->save($tmpPath);

            } finally {
                return $renderImage;
            }
        }
    }

    public function getImagePath(Image $image, int $resizeType = NetteImage::EXACT, $width = null, $height = null, $fileType = null): string
    {
        $extensions = array_flip(self::FORMATS) + ['jpg' => NetteImage::JPEG];

        if ($fileType == null) {
            $fileType = $extensions[$image->getFileExtension()];

            if ($fileType !== NetteImage::GIF && $this->imageConfig->isWebpOptimization()) {
                $fileType = NetteImage::WEBP;
            }
        }

        $widthType = strpos($width, '%') !== false ? 'pix' : 'pct';
        $heightType = strpos($height, '%') !== false ? 'pix' : 'pct';

        return $this->imageConfig->getCachePath() . '/' . $fileType . '/' . (int) $width . $widthType . '_' . (int) $height . $heightType . '_' . $resizeType . '/' . (string) $image->getId() . self::FORMATS[$fileType];
    }
}