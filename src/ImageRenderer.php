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

    /** @var ImageStorage */
    private $imageStorage;

    /** @var array */
    private const FORMATS = [NetteImage::JPEG => 'jpeg', NetteImage::PNG => 'png', NetteImage::GIF => 'gif', NetteImage::WEBP => 'webp'];

    public function __construct(
        ImageConfig $imageConfig,
        ImageStorage $imageStorage
    ) {
        $this->imageConfig = $imageConfig;
        $this->imageStorage = $imageStorage;
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
        $tmpPath = $this->createTempPath($image, $resizeType, $width, $height, $fileType);

        try {
            NetteImage::fromFile($tmpPath)->send();

        } catch (UnknownImageFileException $e) {
            $this->imageStorage->saveTemp($tmpPath, $image, $resizeType, $width, $height, $fileType)->send();
        }
    }

    /**
     * @param Image $image
     * @param int $resizeType
     * @param null $width
     * @param null $height
     * @param null $fileType
     * @return string
     */
    public function createTempPath(Image $image, int $resizeType = NetteImage::EXACT, $width = null, $height = null, $fileType = null): string
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