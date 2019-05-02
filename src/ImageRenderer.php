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
     * @throws ImageException
     */
    public function render(UuidInterface $uuid, ImageInterface $image, int $width = null, int $height = null, int $resizeType = NetteImage::EXACT): void
    {
        NetteImage::fromFile($this->createTempPath($uuid, $image, $width, $height, $resizeType))->send();
    }

    /**
     * @throws ImageException
     */
    public function generate(UuidInterface $uuid, ImageInterface $image, int $width = null, int $height = null, int $resizeType = NetteImage::EXACT): string
    {
        $tempPath = $this->createTempPath($uuid, $image, $width, $height, $resizeType);

        if (file_exists($tempPath) === false) {
            $this->imageStorage->saveTemp($tempPath, $image, $width, $height, $resizeType);
        }

        return $tempPath;
    }

    /**
     * @return string
     */
    public function createTempPath(UuidInterface $uuid, ImageInterface $image, int $width, int $height, $resizeType = NetteImage::EXACT): string
    {
		if ($width === null) {
			$width = 0;
		}

		if ($height === null) {
			$height = 0;
		}

        return $this->imageConfig->getCachePath() . '/' . $image->getFileFormat() . '/' . (int) $width . '_' . (int) $height . '_' . $resizeType . '/' . (string) $uuid . '.' . $image->getFileFormat();
    }
}
