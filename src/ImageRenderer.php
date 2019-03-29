<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Nette\Utils\Image as NetteImage;
use Nette\Utils\ImageException;
use Ramsey\Uuid\UuidInterface;

class ImageRenderer
{
    /** @var ImageConfig */
    private $imageConfig;

    /** @var ImageStorage */
    private $imageStorage;

    public function __construct(
        ImageConfig $imageConfig,
        ImageStorage $imageStorage
    ) {
        $this->imageConfig = $imageConfig;
        $this->imageStorage = $imageStorage;
    }

    /**
     * @param UuidInterface $uuid
     * @param ImageData $imageData
     * @param int $resizeType
     * @throws ImageException
     */
    public function render(UuidInterface $uuid, ImageData $imageData, int $resizeType = NetteImage::EXACT): void
    {
        NetteImage::fromFile($this->createTempPath($uuid, $imageData, $resizeType))->send();
    }

    /**
     * @param UuidInterface $uuid
     * @param ImageData $imageData
     * @param int $resizeType
     * @return string Save path
     * @throws ImageException
     */
    public function generate(UuidInterface $uuid, ImageData $imageData, int $resizeType = NetteImage::EXACT): string
    {
        $tempPath = $this->createTempPath($uuid, $imageData, $resizeType);

        if (file_exists($tempPath) === false) {
            $this->imageStorage->saveTemp($tempPath, $imageData, $resizeType);
        }

        return $tempPath;
    }

    /**
     * @param UuidInterface $uuid
     * @param ImageData $imageData
     * @param int $resizeType
     * @return string
     */
    public function createTempPath(UuidInterface $uuid, ImageData $imageData, $resizeType = NetteImage::EXACT): string
    {
        return $this->imageConfig->getCachePath() . '/' . $imageData->fileFormat . '/' . (int) $imageData->width. '_' . (int) $imageData->height . '_' . $resizeType . '/' . (string) $uuid . '.' . $imageData->fileFormat;
    }
}