<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Nette\Utils\Image as NetteImage;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
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
    public function render(UuidInterface $uuid, ImageData $imageData, $resizeType = NetteImage::EXACT): void
    {
        $tempPath = $this->createTempPath($uuid, $imageData, $resizeType);

        try {
            NetteImage::fromFile($tempPath)->send();

        } catch (UnknownImageFileException $e) {
            $this->imageStorage->saveTemp($tempPath, $imageData, $resizeType)->send();
        }
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